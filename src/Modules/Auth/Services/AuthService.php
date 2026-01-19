<?php
namespace App\Modules\Auth\Services;

use PDO;

class AuthService {
    private $conn;
    private $maxLoginAttempts = 5;
    private $lockoutTime = 180;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function login($username, $password) {
        if ($this->isAccountLocked($username)) {
            return ['success' => false, 'error' => 'Account temporarily locked'];
        }
        $query = "SELECT id, username, email, password, role, full_name FROM users WHERE (username = ? OR email = ?) AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $username]);
        
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $user['password'])) {
                $this->clearLoginAttempts($username);
                $this->createSecureSession($user);
                return ['success' => true];
            }
        }

        $this->recordFailedAttempt($username);
        return ['success' => false, 'error' => 'Invalid credentials'];
    }

    private function createSecureSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['login_time'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    private function isAccountLocked($username) {
        $query = "SELECT COUNT(*) as attempts FROM login_attempts WHERE username = ? AND attempt_time > ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, time() - $this->lockoutTime]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['attempts'] >= $this->maxLoginAttempts;
    }

    private function recordFailedAttempt($username) {
        $query = "INSERT INTO login_attempts (username, attempt_time) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, time()]);
    }

    private function clearLoginAttempts($username) {
        $query = "DELETE FROM login_attempts WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
    }

    public function register($username, $email, $password, $full_name, $university, $role) {
        try {
            if ($this->emailExists($email)) {
                return ['success' => false, 'message' => 'Email already exists'];
            }

            $query = "SELECT id FROM users WHERE username = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'Username already exists'];
            }

            $query = "INSERT INTO users (username, email, password, full_name, university, role) VALUES (?, ?, ?, ? ,? , ?)";
            $stmt = $this->conn->prepare($query);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $result = $stmt->execute([$username, $email, $hashed_password, $full_name, $university, $role]);

            return ['success' => $result, 'message' => $result ? 'Registration successful' : 'Registration failed'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Registration failed: ' . $e-getMessage()];
        }
    }

    public function emailExists($email) {
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    public function getCurrentUser() {
        if(isset($_SESSION['user_id'])) {
            $query = "SELECT id, username, email, full_name, role, university, avatar, status, reputation, created_at FROM users WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === 'admin';
    }
}

<?php
namespace App\Modules\Auth\Services;

use PDO;

class AuthService {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function login($username, $password) {
        $query = "SELECT id, username, email, password, role, full_name FROM users WHERE (username = ? OR email = ?) AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $username]);
        
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                return true;
            }
        }
        return false;
    }

    public function register($username, $email, $password, $full_name, $university, $role) {
        $query = "INSERT INTO users (username, email, password, full_name, university, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $email, $hashed_password, $full_name, $university, $role]);
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

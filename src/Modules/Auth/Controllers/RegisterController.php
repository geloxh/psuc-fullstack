<?php
namespace App\Modules\Auth\Controllers;

use App\Web\Controllers\BaseController;

class RegisterController extends BaseController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->render('auth/register', ['error' => '', 'success' => '']);
    }
    
    public function store() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once __DIR__ . '/../../../../db/database.php';
        require_once __DIR__ . '/../Services/AuthService.php';
        
        $database = new \Database();
        $auth = new \App\Modules\Auth\Services\AuthService($database->getConnection());
        
        $error = '';
        
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $error = "Passwords do not match.";
        } elseif (strlen($_POST['password']) < 6) {
            $error = "Password must be at least 6 characters long.";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } elseif ($auth->emailExists($_POST['email'])) {
            $error = "Email already exists.";
        } else {
            if ($auth->register($_POST['username'], $_POST['email'], $_POST['password'], 
                              $_POST['full_name'], $_POST['university'], $_POST['role'])) {
                $this->render('auth/register', ['success' => 'Registration successful. You can now login.', 'error' => '']);
                return;
            } else {
                $error = "Registration failed.";
            }
        }
        
        $this->render('auth/register', ['error' => $error, 'success' => '']);
    }
}

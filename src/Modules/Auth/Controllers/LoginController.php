<?php
namespace App\Modules\Auth\Controllers;

use App\Web\Controllers\BaseController;

class LoginController extends BaseController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->render('auth/login', ['error' => '']);
    }
    
    public function store() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once __DIR__ . '/../../../../db/database.php';
        require_once __DIR__ . '/../Services/AuthService.php';
        
        $database = new \Database();
        $auth = new \App\Modules\Auth\Services\AuthService($database->getConnection());
        
        if ($auth->login($_POST['username'], $_POST['password'])) {
            $this->redirect('/');
        } else {
            $this->render('auth/login', ['error' => 'Invalid credentials']);
        }
    }
}

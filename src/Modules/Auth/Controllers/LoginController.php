<?php
namespace App\Modules\Auth\Controllers;

use App\Web\Controllers\BaseController;
use App\Modules\Auth\Services\AuthService;

class LoginController extends BaseController {
    private $authService;

    public function __construct(AuthService $authService) {
        parent::__construct();
        $this->authService = $authService;
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->render('auth/login', ['error' => '']);
    }
    
    public function store() {
        if ($this->authService->login($_POST['username'], $_POST['password'])) {
            $this->redirect('/');
        } else {
            $this->render('auth/login', ['error' => 'Invalid credentials']);
        }
    }
}

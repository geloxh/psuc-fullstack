<?php
namespace App\Modules\Auth\Controllers;

use App\Web\Controllers\BaseController;
use App\Modules\Auth\Services\AuthService;
use App\Core\Database\Connection;

class LoginController extends BaseController {
    private $authService;

    public function __construct() {
        $database = Connection::getInstance();
        $this->authService = new AuthService($database->getConnection());
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $error = '';

        // Login 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->authService->login($_POST['username'], $_POST['password']);
            if ($result['success']) {
                $this->redirect('/suc-fullstack/public');
            } else {
                $error = $result['error'];
            }
        }

        $this->renderWithoutLayout('auth/login', [
            'title' => 'Login - SUC Forum',
            'error' => $error
        ]);

    }
    
    public function store() {
        return $this->index(); // Handle POST in index method
    }

    protected function renderWithoutLayout($view, $data = []) {
        extract($data);

        if (strpos($view, '/') !== false) {
            $parts = explode('/', $view, 2);
            $module = ucfirst($parts[0]);
            $viewFile = $parts[1];
            $viewPath = __DIR__ . "/../Views/{$viewFile}.php";
        } else {
            $viewPath = __DIR__ . "/../Views/{$view}.php";
        }
        
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View not found: {$view}";
            exit;
        }
    }
}

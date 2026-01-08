<?php
namespace App\Web\Controllers;

abstract class BaseController {
    protected function render($view, $data = []) {
        extract($data);
        
        ob_start();
        
        if (strpos($view, '/') !== false) {
            $parts = explode('/', $view, 2);
            $module = ucfirst($parts[0]);
            $viewFile = $parts[1];
            $viewPath = __DIR__ . "/../../Modules/{$module}/Views/{$viewFile}.php";
        } else {
            $viewPath = __DIR__ . "/../Views/{$view}.php";
        }

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new Exception("View not found: {$view}");
        }

        $content = ob_get_clean();
        $title = $data['title'] ?? 'PSUC Forum';
        include __DIR__ . "/../Views/layouts/main.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function requireAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    protected function requireAdmin() {
        $this->requireAuth();
        require_once __DIR__ . '/../../../db/database.php';
        require_once __DIR__ . '/../../Modules/Auth/Services/AuthService.php';
    
        $database = new \Database();
        $auth = new \App\Modules\Auth\Services\AuthService($database->getConnection());
        if (!$auth->isAdmin()) {
            $this->redirect('/');
        }
    }


}

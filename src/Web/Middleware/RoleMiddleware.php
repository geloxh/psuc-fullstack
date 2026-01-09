<?php
namespace App\Web\Middleware;

class RoleMiddleware {
    public static function requireRole($requiredRole) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userRole = $_SESSION['role'] ?? 'user';

        $roleHierarchy = [
            'user' => 1,
            'moderator' => 2,
            'admin' => 3
        ];
        
        if (($roleHierarchy[$userRole] ?? 0) < ($roleHierarchy[$requiredRole] ?? 999)) {
            http_response_code(403);
            header('Location: /403');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireRole('admin');
    }
}
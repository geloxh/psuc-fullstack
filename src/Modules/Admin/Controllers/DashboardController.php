<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\AdminService;

class DashboardController {
    private $adminService;
    public function __construct(AdminService $adminService) {
        $this->adminService = $adminService;
    }

    public function index() {
        if (!$this->isAdmin()) {
            header('Location: ../login.php');
            exit;
        }
        
        $stats = $this->adminService->getDashboardStats();
        $recent_users = $this->adminService->getRecentUsers();
        $top_topics = $this->adminService->getTopTopics();

        include __DIR__ . '/../Views/dashboard.php';
    }

    private function isAdmin() {
        $auth = new \Auth();
        return $auth->isAdmin();
    }
}
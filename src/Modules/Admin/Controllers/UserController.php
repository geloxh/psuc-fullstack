<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\AdminService;

class UserController {
    private $adminService;

    public function __construct(AdminService $adminService) {
        $this->adminService = $adminService;
    }

    public function index() {
        if (!$this->isAdmin()) {
            header('Location: ../login.php');
            exit;
        }

        // Handle AJAX requests
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');

            if ($_POST['action'] == 'update_role') {
                try {
                    $result = $this->adminService->updateUserRole($_POST['user_id'], $_POST['role']);
                    echo json_encode(['success' => $result]);
                } catch (\Exception $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
                exit;
            }

            if ($_POST['action'] == 'delete_user') {
                $result = $this->adminService->deleteUser($_POST['user_id']);
                echo json_encode(['success' => $result]);
                exit;
            }
        }

        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';
        $role_filter = $_GET['role'] ?? '';

        $data = $this->adminService->getUsers($search, $role_filter, $page);

        include __DIR__ . '/../Views/users.php';
    }

    private function isAdmin() {
        $auth = new \Auth();
        return $auth->isAdmin();
    }
}
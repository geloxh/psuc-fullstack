<?php
namespace App\Modules\Admin\Services;

use App\Modules\Admin\Repositories\AdminRepository;

class AdminService {
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository) {
        $this->adminRepository = $adminRepository;
    }

    public function getDashboardStats() {
        return $this->adminRepository->getStats();
    }

    public function getRecentUsers($limit = 5) {
        return $this->adminRepository->getRecentUsers($limit);
    }

    public function getTopTopics($limit = 5) {
        return $this->adminRepository->getTopTopics($limit);
    }

    public function getUsers($search = '', $role_filter = '', $page = 1, $per_page = 20) {
        $offset = ($page - 1) * $per_page;
        $users = $this->adminRepository->getUsers($search, $role_filter, $per_page, $offset);
        $total = $this->adminRepository->getUserCount($search, $role_filter);

        return [
            'users' -> $users,
            'total' -> $total,
            'total_pages' -> ceil($total / $per_page)
        ];
    }

    public function updateUserRole($user_id, $role) {
        $allowed_roles = ['admin', 'moderator', 'faculty', 'student'];
        if (!in_array($role, $allowed_roles)) {
            throw new \Exception('Inavalid role.');
        }

        return $this->adminRepository->updateUserRole($user_id, $role);
    }

    public function deleteUser($user_id) {
        return $this->adminRepository->deleteUser($user_id);
    }
}

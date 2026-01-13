<?php
namespace App\Modules\User\Controllers;

use App\Web\Controllers\BaseController;
use App\Modules\User\Services\UserService;

class NotificationController extends BaseController {
    private $userService;
    
    public function __construct() {
        $this->userService = new UserService();
    }
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $notifications = $this->userService->getNotifications($_SESSION['user_id']);
        return $this->view('user/notifications', ['notifications' => $notifications]);
    }
}

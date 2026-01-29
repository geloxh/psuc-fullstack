<?php
namespace App\Modules\Messaging\Controllers;

use App\Modules\Messaging\Services\MessageService;
use App\Web\Controllers\BaseController;
use App\Core\Database\Connection;

class MessageController extends BaseController {
    private $messageService;

    public function __construct() {
        $database  = Connection::getInstance();
        $this->messageService = new MessageService($database->getConnection());
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/suc-fullstack/login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $error = '';
        $success = '';

        // Handle delete message
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
            try {
                $result = $this->messageService->deleteMessage($_POST['message_id'], $user_id);

                if ($result) {
                    $success = "Messsage deleted successfully.";
                    $this->redirect('/suc-fullstack/messages?view=' . ($_GET['view'] ?? 'inbox') . '&deleted=1');
                    exit;
                }
            } catch (\Exception $e) {
                $error = "Failed to delete message.";
            }
        }

        // Handle sending message
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
            try {
                $result = $this->messageService->sendMessage(
                    $user_id,
                    $_POST['receiver_id'],
                    $_POST['subject'],
                    $_POST['content']
                );

                if ($result) {
                    $this->redirect('/suc-fullstack/messages?view=' . ($_GET['view'] ?? 'inbox') . '&success=1');
                    exit;
                }
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        $view = $_GET['view'] ?? 'inbox';
        $selected_message = $_GET['message'] ?? null;

        // Get messages
        $messages = $this->messageService->getMessages($user_id, $view);

        // Get selected message
        $message_detail = null;
        if ($selected_message) {
            $message_detail = $this->messageService->getMessageById($selected_message, $user_id);
        }

        // Get users for messaging
        $users = $this->messageService->getUsers($user_id);

        // Get unread count
        $unread_count = $this->messageService->getUnreadCount($user_id);

        $this->render('messaging/messages', [
            'title' => 'Messages',
            'messages' => $messages,
            'message_detail' => $message_detail,
            'users' => $users,
            'unread_count' => $unread_count,
            'error' => $error,
            'success' => $success,
            'view' => $view,
        ]);
    }
}
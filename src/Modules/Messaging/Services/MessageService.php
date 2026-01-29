<?php
namespace App\Modules\Messaging\Services;

use App\Modules\Messaging\Repositories\MessageRepository;

class MessageService {
    private $messageRepository;

    public function __construct(MessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    public function getMessages($user_id, $view = 'inbox') {
        if ($view === 'sent') {
            return $this->messageRepository->getSentMessages($user_id);
        }
        return $this->messageRepository->getInboxMessages($user_id);
    }

    public function getMessageById($message_id, $user_id) {
        $message = $this->messageRepository->getMessageById($message_id, $user_id);

        // Mark as read if it's received by current user
        if ($message && $message['receiver_id'] == $user_id && !$message['is_read']) {
            $this->messageRepository->markAsRead($message_id, $user_id);
            $message['is_read'] = 1;
        }
        
        return $message;
    }

    public function sendMessage($sender_id, $receiver_id, $subject, $content) {
        if (empty($subject) || empty($content)) {
            throw new \Exception('Subject and content are required.');
        }

        return $this->messageRepository->sendMessage($sender_id,  $receiver_id, $subject, $content);
    }

    public function deleteMessage($message_id, $user_id) {
        return $this->messageRepository->deleteMessage($message_id, $user_id);
    }

    public function getUnreadCount($user_id) {
        return $this->messageRepository->getUnreadCount($user_id);
    }

    public function getUsers($exclude_user_id) {
        return $this->messageRepository->getUsers($exclude_user_id);
    }
}
<?php
namespace App\Modules\Messaging\Repositories;

use PDO;

class MessageRepository {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getInboxMessages($user_id) {
        $query = "SELECT m.*, u.username as other_user
                FROM messages m
                JOIN users u ON m.sender_id = u.id
                WHERE m.receiver_id = ?
                ORDER BY m.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSentMessages($user_id) {
        $query = "SELECT m.*, u.username as other_user
                FROM messages m
                JOIN users u ON m.receiver_id = u.id
                WHERE m.sender_id = ?
                ORDER BY m.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessageById($message_id, $user_id) {
        $query = "SELECT m.*,
                u1.username as sender_name,
                u2.username as receiver_name
                FROM messages m
                JOIN users u1 ON m.sender_id = u1.id
                JOIN users u2 ON m.receiver_id = u2.id
                WHERE m.id = ? AND (m.sender_id = ? OR m.receiver_id = ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$message_id, $user_id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function sendMessage($sender_id, $receiver_id, $subject, $content) {
        $query = "INSERT INTO messages (sender_id, receiver_id, subject, content) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$sender_id, $receiver_id, $subject, $content]);
    }

    public function deleteMessage($message_id, $user_id) {
        $query = "DELETE FROM messages WHERE id = ? AND (sender_id = ? OR receiver_id = ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$message_id, $user_id, $user_id]);
    }

    public function markAsRead($message_id, $user_id) {
        $query = "UPDATE messages SET is_read = 1 WHERE id = ? AND receiver_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$message_id, $user_id]);
    }

    public function getUnreadCount($user_id) {
        $query = "SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getUsers($exclude_user_id) {
        $query = "SELECT id, username FROM users WHERE id != ? ORDER BY username";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$exclude_user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
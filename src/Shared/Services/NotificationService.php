<?php
namespace App\Shared\Services;

class NotificationService {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function create($user_id, $type, $title, $content, $url = null) {
        $query = "INSERT INTO notifications (user_id, type, title, content, url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id, $type, $title, $content, $url]); 
    }

    public function getByUser($user_id, $limit = 10) {
        $query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function markAsRead($notification_id, $user_id) {
        $query = "UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$notification_id, $user_id]);
    }
}
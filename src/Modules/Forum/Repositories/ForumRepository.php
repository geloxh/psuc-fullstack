<?php
namespace App\Modules\Forum\Repositories;

use PDO;

class ForumRepository {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getCategories() {
        $query = "SELECT * FROM categories ORDER BY position, name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getForumsByCategory($category_id) {
        $query = "SELECT f.*, 
              (SELECT COUNT(*) FROM topics WHERE forum_id = f.id) as topics_count,
              (SELECT COUNT(*) FROM posts p JOIN topics t ON p.topic_id = t.id WHERE t.forum_id = f.id) as posts_count
              FROM forums f WHERE category_id = ? ORDER BY position, name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentTopics($limit = 10) {
        $query = "SELECT t.*, u.username, f.name as forum_name,
            (SELECT COUNT(*) FROM posts WHERE topic_id = t.id) as replies_count
            FROM topics t
            JOIN users u ON t.user_id = u.id
            JOIN forums f ON t.forum_id = f.id
            ORDER BY t.created_at DESC
            LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getForumStats() {
        $query = "SELECT
            (SELECT COUNT(*) FROM topics) as total_topics,
            (SELECT COUNT(*) FROM posts) as total_posts,
            (SELECT COUNT(*) FROM users) as total_users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTopic($forum_id, $user_id, $title, $content) {
        $query = "INSERT INTO topics (forum_id, user_id, title, content) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$forum_id, $user_id, $title, $content]);
        return $this->conn->lastInsertId();
    }

    public function getForumInfo($forum_id) {
        $query = "SELECT name, description FROM forums WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$forum_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getForumWithCategory($forum_id) {
        $query = "SELECT f.*, c.name as category_name,
                (SELECT COUNT(*) FROM posts p JOIN topics t ON p.topic_id = t.id WHERE t.forum_id = f.id) as posts_count
                FROM forums f
                JOIN categories c ON f.category_id = c.id
                WHERE f.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$forum_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalTopics($forum_id) {
        $query = "SELECT COUNT(*) as total FROM topics WHERE forum_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$forum_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}

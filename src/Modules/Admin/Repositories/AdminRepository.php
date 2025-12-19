<?php
namespace App\Modules\Admin\Repositories;

use PDO;

class AdminRepository {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getStats() {
        $query = "SELECT
            (SELECT COUNT(*) FROM users) as total_users,
            (SELECT COUNT(*) FROM topics) as total_topics,
            (SELECT COUNT(*) FROM posts) as total_posts,
            (SELECT COUNT(*) FROM users) WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)) as new_users_week,
            (SELECT COUNT(*) FROM topics) WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)) as topics_today,
            (SELECT COUNT(*) FROM posts) WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)) as posts_today";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);    
    }

    public function getRecentUsers($limit = 5) {
        $query = "SELECT username, full_name, created_at FROM users ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopicTopics($limit = 5) {
        $query = "SELECT t.title, t.created_at, u.username,
            (SELECT COUNT(*) FROM posts WHERE p.topic_id = t.id) as reply_count
            FROM topics t JOIN users u ON t.user_id = u.id
            ORDER BY reply_count DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsers($search = '', $role_filter = '', $limit = 20, $offset = 0) {
        $where_conditions = [];
        $params = [];

        if ($search) {
            $where_conditions[] = "(username LIKE ? OR email LIKE ? OR full_name LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if ($role_filter) {
            $where_conditions[] = "role = ?";
            $params[] = $role_filter;
        }

        $where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";

        $query = "SELECT * FROM users $where_clause ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserCount($search = '',  $role_filter = '') {
        $where_conditions = [];
        $params = [];

        if ($search) {
            $where_conditions[] = "(username LIKE ? OR email LIKE ? OR full_name LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if ($role_filter) {
            $where_conditions[] = "role = ?";
            $params[] = "$role_filter";
        }

        $where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";

        $query = "SELECT COUNT(*) FROM users $where_clause";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function updateUserRole($user_id, $role) {
        $query = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$role, $user_id]);
    }

    public function deleteUser($user_id) {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id]);
    }
}
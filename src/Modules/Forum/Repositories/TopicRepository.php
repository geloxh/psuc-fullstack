<?php
namespace App\Modules\Forum\Repositories;

use PDO;

class TopicRepository {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getTopics($forum_id, $limit = 20, $offset = 0) {
        $query = "SELECT t.*, u.username, u.avatar,
                (SELECT COUNT(*) FROM posts WHERE topic_id = t.id) as replies_count,
                CONCAT(
                    (SELECT u2.username FROM posts p2 JOIN users u2 ON p2.user_id = u2.id WHERE p2.topic_id = t.id ORDER BY p2.created_at DESC LIMIT 1),
                    '|',
                    (SELECT p2.created_at FROM posts p2 WHERE p2.topic_id = t.id ORDER BY p2.created_at DESC LIMIT 1)
                ) as last_reply
                FROM topics t
                JOIN users u ON t.user_id = u.id
                WHERE forum_id = ?
                ORDER BY is_pinned DESC, updated_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $forum_id, PDO::PARAM_INT);
        $stmt->bindValue(2, (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentTopics($limit = 10) {
        $query = "SELECT
                    t.id,
                    t.title,
                    t.content,
                    t.created_at,
                    t.views,
                    u.username,
                    u.avatar,
                    f.name as forum_name,
                    (SELECT COUNT(*) FROM posts WHERE topic_id = t.id) as reply_count
                FROM
                    topics t
                JOIN
                    users u ON t.user_id = u.id
                JOIN
                    forums f ON t.forum_id = f.id
                ORDER BY
                    t.created_at DESC
                LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrendingTopics($limit = 5) {
        $query = "SELECT t.id, t.title, t.views, u.username,
                (SELECT COUNT(*) FROM posts p WHERE p.topic_id = t.id) as reply_count
                FROM topics t
                JOIN users u ON t.user_id = u.id
                ORDER BY t.views DESC, reply_count DESC
                LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopicById($topic_id) {
        $query = "SELECT t.*, u.username, u.avatar, u.reputation, u.role, f.name as forum_name
                FROM topics t
                JOIN users u ON t.user_id = u.id
                JOIN forums f ON t.forum_id = f.id
                WHERE t.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$topic_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTopicsWithDetails($forum_id, $limit = 20, $offset = 0) {
        $query = "SELECT t.*, u.username, u.avatar,
                (SELECT COUNT(*) FROM posts WHERE topic_id = t.id) as replies_count,
                CONCAT(
                    COALESCE((SELECT u2.username FROM posts p2 JOIN users u2 ON p2.user_id = u2.id WHERE p2.topic_id = t.id ORDER BY p2.created_at DESC LIMIT 1), ''),
                    '|',
                    COALESCE((SELECT p2.created_at FROM posts p2 WHERE p2.topic_id = t.id ORDER BY p2.created_at DESC LIMIT 1), '')
                ) as last_reply
                FROM topics t
                JOIN users u ON t.user_id = u.id
                WHERE forum_id = ?
                ORDER BY is_pinned DESC, updated_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $forum_id, PDO::PARAM_INT);
        $stmt->bindValue(2, (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($forum_id, $user_id, $title, $content) {
        $query = "INSERT INTO topics (forum_id, user_id, title, content) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$forum_id, $user_id, $title, $content]);
        return $this->conn->lastInsertId();
    }

    public function update($topic_id, $title, $content) {
        $query = "UPDATE topics SET title = ?, content = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$title, $content, $topic_id]);
    }

    public function delete($topic_id) {
        $query = "DELETE FROM topics WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$topic_id]);
    }

    public function incrementViews($topic_id) {
        $query = "UPDATE topics SET views = views + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$topic_id]);
    }
}

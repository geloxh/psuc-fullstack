<?php
namespace App\Modules\Documents\Repositories;

class DocumentRepository {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getApproved() {
        $query = "SELECT * FROM documents WHERE status = 'approved' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM documents WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function incrementDownloads($id) {
        $query = "UPDATE documents SET downloads = downloads + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
    }
}
<?php 
namespace App\Modules\User\Repositories;

class GroupRepository {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getAll() {
        $query = "SELECT * FROM user_groups WHERE status = 'active' ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM user_groups WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
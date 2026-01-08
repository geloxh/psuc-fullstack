<?php
class Database {
    private $connection;

    public function __construct() {
        $this->connection = \App\Core\Database\Connection::getInstance()->getConnection();
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
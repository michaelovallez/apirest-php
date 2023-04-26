<?php
require_once(__DIR__ . '/../Config/database.php');
class Model
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    protected function executeQuery($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}

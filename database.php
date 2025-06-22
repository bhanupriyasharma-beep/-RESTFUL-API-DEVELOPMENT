<?php
class Database {
    private $host = "localhost";
    private $db_name = "library";
    private $username = "root";
    private $password = ""; // set if needed
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
        return $this->conn;
    }
}
?>

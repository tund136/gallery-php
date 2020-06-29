<?php
require_once("config.php");

class Database {
    private $connection;

    function __construct() {
        $this->open_db_connection();
    }

    public function open_db_connection() {
        // $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if($this->connection->connect_errno) {
            die("Database connection failed. ".$this->connection->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);

        $this->confirmQuery($result);

        return $result;
    }

    // confirm query
    private function confirmQuery($result) {

        if(!$result) {
            die("Query Failed!".$this->connection->error);
        }
    }

    // escape string
    public function escapeString($string) {
        $escapedString = $this->connection->real_escape_string($string);

        return $escapedString;
    }

    // insert id
    public function theInsertId() {
        return $this->connection_insert_id;
    }
}

$database = new Database();

?>
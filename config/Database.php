<?php

class Database {
  // DB Params
  private $host = 'localhost';
  private $db_name = 'my_blog';
  private $username = 'root';
  private $password = '';
  private $conn;

  public function connect() {
    $this->conn = null;

    try {
      $this->conn = new PDO(
        'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
        $this->username,
        $this->password
      );
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $err) {
      //throw $err;
      echo 'Database Connection Error: ' . $err->getMessage();
    }
    return $this->conn;
  }
}
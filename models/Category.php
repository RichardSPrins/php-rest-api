<?php

class Category
{
  // DB information: private properties
  private $conn;
  private $table = 'categories';

  // Set public Properties
  public $id;
  public $name;
  public $created_at;

  // Constructor with DB Instance
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function read()
  {
    $query = 'SELECT 
              id,
              name,
              created_at
              FROM ' . $this->table . ' 
              ORDER BY
              created_at DESC';

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  public function read_one()
  {
    $query = 'SELECT 
              id,
              name
              FROM ' . $this->table . ' 
              WHERE id = ?
              LIMIT 0,1';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind data Params
    $stmt->bindParam(1, $this->id);

    // Execute Statement
    $stmt->execute();


    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set Properties
    $this->id = $row['id'];
    $this->name = $row['name'];
  }

  public function create()
  {
    $query = 'INSERT INTO ' . $this->table . ' 
            SET 
            name = :name';
    $stmt = $this->conn->prepare($query);

    // Sanitize Data
    $this->name = htmlspecialchars(strip_tags($this->name));


    // Bind data params
    $stmt->bindParam(':name', $this->name);

    // Execute Query
    if ($stmt->execute()) {
      return true;
    } else {
      // Print error if failed
      printf("Error: %s.\n", $stmt->err);
      return false;
    }
  }


  public function update()
  {
  }

  public function delete()
  {
  }
}

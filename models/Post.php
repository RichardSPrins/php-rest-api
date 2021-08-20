<?php

class Post
{
  // Private attrs
  private $conn;
  private $table = 'posts';

  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;

  // Constructor with DB Instance
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // READ All Posts

  public function read()
  {
    // Create Query
    $query = 'SELECT c.name as category_name, 
              p.id, 
              p.category_id, 
              p.title, 
              p.body, 
              p.author, 
              p.created_at 
              FROM ' . $this->table . ' p 
              LEFT JOIN categories c ON p.category_id = c.id
              ORDER BY p.created_at DESC';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  // READ One Post by ID

  public function read_one()
  {
    $query = 'SELECT c.name as category_name, 
              p.id, 
              p.category_id, 
              p.title, 
              p.body, 
              p.author, 
              p.created_at 
              FROM ' . $this->table . ' p 
              LEFT JOIN categories c ON p.category_id = c.id
              WHERE p.id = ?
              LIMIT 0,1';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();


    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set Properties
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
  }

  // Create new Post
  public function create()
  {
    $query = 'INSERT INTO ' . $this->table . ' SET 
              title = :title,
              body = :body,
              author = :author,
              category_id = :category_id';
    $stmt = $this->conn->prepare($query);

    // Sanitize Data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    // Bind data params
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);

    // Execute Query
    if ($stmt->execute()) {
      return true;
    } else {
      // Print error if failed
      printf("Error: %s.\n", $stmt->err);
      return false;
    }
  }

  // Update Post by ID

  public function update()
  {
    $query = 'UPDATE ' . $this->table . ' SET 
              title = :title,
              body = :body,
              author = :author,
              category_id = :category_id
              WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    // Sanitize Data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data params
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);

    // Execute Query
    if ($stmt->execute()) {
      return true;
    } else {
      // Print error if failed
      printf("Error: %s.\n", $stmt->err);
      return false;
    }
  }

  // Delete
  public function delete()
  {
    $query = 'DELETE FROM ' . $this->table . ' 
              WHERE id = :id';

    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // Sanitize ID input
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data params
    $stmt->bindParam(':id', $this->id);

    // Execute Query
    if ($stmt->execute()) {
      return true;
    } else {
      // Print error if failed
      printf("Error: %s.\n", $stmt->err);
      return false;
    }
  }
}

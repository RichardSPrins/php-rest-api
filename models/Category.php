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
}

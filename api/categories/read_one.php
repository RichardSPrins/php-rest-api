<?php 
// Set Headers for Access/Parsing
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate Database
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : exit("Please Provide ID");

// Get Post
$category->read_one();

// Create Array
$category_array = array(
  'id' => $category->id,
  'name' => $category->name,
);

// Convert to JSON
print_r(json_encode($category_array));
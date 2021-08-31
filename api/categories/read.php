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

// Blog Category Query

$result = $category->read();

$count = $result->rowCount();

// Check for posts
if($count > 0){
  // Creat Posts data array
  $category_arr = array();
  $category_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    # code...
    extract($row);

    $category_item = array(
      'id' => $id,
      'name' => $name
    );
    
    // Push to $posts_arr['data']
    array_push($category_arr['data'], $category_item);
  }

  // Convert to JSON  & output
  echo json_encode($category_arr);
} else {
  // No Posts
  echo json_encode(
    array('message' => 'No Categories Found')
  );
}
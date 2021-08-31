<?php
// Set Headers for Access/Parsing
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate Database
$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Get Raw POST data
$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

// Create post
if ($category->create()) {
  echo json_encode(array('message' => 'Category Created'));
} else {
  echo json_encode(array('message' => 'Category Not Created'));
}

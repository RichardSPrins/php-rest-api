<?php 
// Set Headers for Access/Parsing
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate Database
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$post = new Post($db);

$post->id = isset($__GET['id']) ? $_GET['id'] : exit("Please Provide ID");

// Get Post
$result = $post->read_one();
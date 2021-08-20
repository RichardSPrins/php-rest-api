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

// Blog Post Query

$result = $post->read();

$count = $result->rowCount();

// Check for posts
if($count > 0){
  // Creat Posts data array
  $posts_arr = array();
  $posts_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    # code...
    extract($row);

    $post_item = array(
      'id' => $id,
      'title' => $title,
      'body' => html_entity_decode($body),
      'author' => $author,
      'category_id' => $category_id,
      'category_name' => $category_name
    );
    
    // Push to $posts_arr['data']
    array_push($posts_arr['data'], $post_item);
  }

  // Convert to JSON  & output
  echo json_encode($posts_arr);
} else {
  // No Posts
  echo json_encode(
    array('message' => 'No Posts Found')
  );
}
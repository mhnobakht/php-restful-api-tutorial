<?php

// include post class
require_once 'Post.php';

// set response headet to json
header("Content-Type: application/json");

// get method
$method  = $_SERVER['REQUEST_METHOD'];

// get path info
@$path = explode("/", $_SERVER['PATH_INFO']);


$post = new Post();


switch ($method) {
    case 'GET':
        if ($path[1] == 'posts') {
            if(isset($path[2])) {
                $response = $post->getPostById($path[2]);
                http_response_code(200);
            }else {
                $response = $post->getPosts();
                http_response_code(200);
            }
        }else {
            $response = [
                "message" => "Endpoint not found!"
            ];
            http_response_code(404);
        }
        break;
    case 'POST':
        if($path[1] == 'posts') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $response = $post->createPost($title, $description);
            http_response_code(201);
        }else {
            $response = [
                "message" => "Endpoint not found!"
            ];
            http_response_code(404);
        }
        break;
    case 'PUT':
        if ($path[1] == 'posts' && isset($path[2])) {
            $id = $path[2];
            parse_str(file_get_contents('php://input'), $putData);
            $title = $putData['title'];
            $description = $putData['description'];
            $response = $post->updatePost($id, $title, $description);
        }else {
            $response = [
                "message" => "Endpoint not found!"
            ];
            http_response_code(404);
        }
        break;
    case 'DELETE':
        if($path[1] == 'posts' && isset($path[2])) {
            $id = $path[2];
            $post->deletePost($id);
            http_response_code(204);
        }else {
            $response = [
                "message" => "Endpoint not found!"
            ];
            http_response_code(404);
        }
        break;
    default:
        $response = [
            "message" => "Method not allowed"
        ];
}


// output
echo json_encode($response);
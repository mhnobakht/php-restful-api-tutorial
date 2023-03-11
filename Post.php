<?php

require_once 'config.php';

class Post {
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPosts() {
        $stmt = $this->conn->prepare("SELECT * FROM posts");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPost($title, $description) {
        $stmt = $this->conn->prepare("INSERT INTO posts (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        return $this->getPostById($this->conn->lastInsertId());
    }

    public function updatePost($id, $title, $description) {
        $stmt = $this->conn->prepare("UPDATE posts SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
        return $this->getPostById($id);
    }

    public function deletePost($id) {
        $stmt = $this->conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$id]);
    }
}

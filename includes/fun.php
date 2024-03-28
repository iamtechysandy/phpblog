<?php
require_once 'config.php';

// Get all posts with categories
function getAllPosts() {
    global $conn;
    $sql = "SELECT posts.*, GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories 
            FROM posts 
            JOIN post_categories ON posts.id = post_categories.post_id
            JOIN categories ON post_categories.category_id = categories.id
            GROUP BY posts.id";
    $result = $conn->query($sql);

    $posts = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }
    return $posts;
}

// Get a single post with categories and tags 
function getPost($id) {
    global $conn;
    $sql = "SELECT posts.*, 
                   GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories,
                   GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags
            FROM posts 
            JOIN post_categories ON posts.id = post_categories.post_id
            JOIN categories ON post_categories.category_id = categories.id
            JOIN post_tags ON posts.id = post_tags.post_id
            JOIN tags ON post_tags.tag_id = tags.id
            WHERE posts.id = ?
            GROUP BY posts.id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Bind the $id parameter
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc(); // Assuming you only want one post
}

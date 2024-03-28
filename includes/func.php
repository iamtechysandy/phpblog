<?php
// Include database configuration
require_once 'config.php';

// Function to fetch a single post by ID from the database
function getPostById($id) {
    global $conn;
    
    $sql = "SELECT * FROM posts WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        return $post;
    } else {
        return null;
    }
}
?>

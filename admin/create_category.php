<?php
require_once '../includes/config.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    // Input sanitization (basic example)
    $name = mysqli_real_escape_string($conn, $name); 

    $sql = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        echo "Category created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

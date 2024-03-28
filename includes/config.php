<?php
// Database configuration
$db_host = "localhost"; // Change this to your MySQL host
$db_user = "root"; // Change this to your MySQL username
$db_password = ""; // Change this to your MySQL password
$db_name = "blog"; // Change this to your MySQL database name

// Attempt to connect to the database
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

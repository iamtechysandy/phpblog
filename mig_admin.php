<?php
// Define admin credentials
$admin_username = 'admin';
$admin_password = 'password';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set in the POST request
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get the entered username and password
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];

        // Validate the entered credentials
        if ($entered_username === $admin_username && $entered_password === $admin_password) {
            // If credentials are correct, return success
            echo "success";
        } else {
            // If credentials are incorrect, return error
            echo "error";
        }
    } else {
        // If username or password is not set in the POST request, return error
        echo "error";
    }
} else {
    // If the request method is not POST, return error
    echo "error";
}
?>

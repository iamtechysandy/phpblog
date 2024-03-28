<?php
require_once 'includes/config.php';

// Fetch categories from the database
$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Display categories
        echo '<li><a href="category.php?category=' . urlencode($row["name"]) . '">' . $row["name"] . '</a></li>';
    }
} else {
    echo "<li>No categories found</li>";
}


?>
<?php
require_once 'includes/config.php';

// Fetch blog posts from the database ordered by creation date
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    $firstPost = true;
    while ($row = mysqli_fetch_assoc($result)) {
        // Display posts
        echo '<div class="card mb-3">';
        if ($firstPost) {
            // Show the latest post in full
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row["title"] . '</h5>';
            echo '<p class="card-text">' . $row["content"] . '</p>';
            
            echo '</div>';
            // Display author name, view count, and posted date
        echo '<div class="post-footer">';
        echo '<span class="author">Author Name: Sandeep Kushwaha</span>';
        echo '<span class="view-count"><i class="fas fa-eye"></i> 2000</span>';
        echo '<span class="posted-date">Posted: ' . date("F j, Y, g:i a", strtotime($row["created_at"])) . '</span>';
        echo '</div>'; // End post-footer
            $firstPost = false;
        } else {
            // Show other posts with a maximum of 10 words and a "Read More" button
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row["title"] . '</h5>';
            
            if (!empty($row["image"])) {
                // Display the image if available
                echo '<center>';
                echo '<img src="uploads/' . $row["image"] . '" class="card-img-top" alt="...">';
                echo '</center>';
            }
            
            echo '<p class="card-text">';
            $contentWords = explode(' ', $row["content"]);
            echo implode(' ', array_slice($contentWords, 0, 50)) . '...';
            echo '</p>';
            echo '<a href="post?title=' . $row["title"] . '" class="btn btn-primary">Read More</a>';
            echo '</div>';
        }
        echo '</div>';
    }
} else {
    echo "0 results";
}



?>
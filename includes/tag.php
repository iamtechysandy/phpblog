<?php
        require_once 'includes/config.php';

        // Fetch tags from the database
        $sql = "SELECT * FROM tags";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Display tags
                echo '<li><a href="#">' . $row["name"] . '</a></li>';
            }
        } else {
            echo "<li>No tags found</li>";
        }

   
      
        ?>
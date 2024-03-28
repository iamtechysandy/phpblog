<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechySandy Blog.</title>
    

    <?php
            require_once 'includes/asset.php';

             ?>
    
   
</head>
<body>
<?php
            require_once 'includes/header.php';

             ?>

<?php
            require_once 'includes/search.php';

             ?>


<?php
            require_once 'includes/topbtn.php';

             ?>
<?php
require_once 'includes/config.php';

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Search options
    $searchInTitle = true; // Search in post titles by default
    $searchInContent = isset($_GET['search_in_content']);
    $searchInTags = isset($_GET['search_in_tags']);

    // Prepare search conditions
    $conditions = [];
    if ($searchInTitle) {
        $conditions[] = "title LIKE '%$searchQuery%'";
    }
    if ($searchInContent) {
        $conditions[] = "content LIKE '%$searchQuery%'";
    }
    if ($searchInTags) {
        $conditions[] = "id IN (SELECT post_id FROM post_tags WHERE tag_id IN (SELECT id FROM tags WHERE name LIKE '%$searchQuery%'))";
    }
    $whereClause = !empty($conditions) ? 'WHERE ' . implode(' OR ', $conditions) : '';

    // Fetch posts from the database that match the search query
    $sql = "SELECT * FROM posts $whereClause";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Output search results
?>
        <div class="container mt-5">
            <h2>Search Results:</h2>
            <div class="row">
<?php
        while ($row = mysqli_fetch_assoc($result)) {
?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $row["title"]; ?></h3>
                            <p class="card-text text-muted">Published on <?php echo date("F j, Y", strtotime($row["created_at"])); ?></p>
                            <p class="card-text"><?php echo substr($row["content"], 0, 200) . '...'; ?></p>
                            <a href="post.php?title=<?php echo urlencode($row["title"]); ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
<?php
        }
?>
            </div> <!-- End row -->
        </div> <!-- End container -->
<?php
    } else {
        echo '<div class="container mt-5"><p>No results found.</p></div>';
    }
} else {
    echo '<div class="container mt-5"><p>No search query provided.</p></div>';
}

// Close database connection

?>



</body>
</html>

<?php
require_once 'includes/config.php';

// Check if category is provided in the URL
if (isset($_GET['category'])) {
    $categoryName = $_GET['category'];

    // Fetch posts belonging to the category from the database
    $sql = "SELECT p.title, p.content, p.created_at, p.image FROM posts p
            INNER JOIN post_categories pc ON p.id = pc.post_id
            INNER JOIN categories c ON pc.category_id = c.id
            WHERE c.name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categoryName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display posts
?>
            <div class="card mb-4">
                <?php if (!empty($row['image'])) { ?>
                    <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
                <?php } ?>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $row['title']; ?></h2>
                    <p class="card-text"><?php echo nl2br($row['content']); ?></p>
                    <p class="card-text"><small class="text-muted">Published on <?php echo date("F j, Y", strtotime($row['created_at'])); ?></small></p>
                </div>
            </div>
<?php
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">No posts found in this category.</div>';
    }
} else {
    echo '<div class="alert alert-info" role="alert">No category selected.</div>';
}


?>

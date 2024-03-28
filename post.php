<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <?php
            require_once 'includes/asset.php';

             ?>
   <style>
    
   </style> 
   
</head>
<body>
<?php
            require_once 'includes/header.php';

             ?>
             <?php
            require_once 'includes/topbtn.php';

             ?>
<div class="container">
<div class="row">
        <!-- Blog content -->
        <div class="main-content">
<?php
require_once 'includes/config.php';

if (isset($_GET['title'])) {
    $postTitle = $_GET['title'];

    // Fetch the post from the database based on the title
    $sql = "SELECT * FROM posts WHERE title = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $postTitle);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Display the post
?>
     
                <div class="col-lg-8 mx-auto">
                    <article>
                        <h1 class="mt-5 mb-4"><?php echo $row["title"]; ?></h1>
                        <div class="mb-4">
                            <p class="text-muted">Published on <?php echo date("F j, Y", strtotime($row["created_at"])); ?></p>
                        </div>
                        <?php
                        if (!empty($row["image"])) {
                            echo '<div class="mb-4">';
                            echo '<img src="uploads/' . $row["image"] . '" class="img-fluid mb-3" alt="' . $row["title"] . '">';
                            echo '</div>';
                        }
                        ?>
                        <div class="mb-5">
                            <p><?php echo nl2br($row["content"]); ?></p>
                        </div>
                    </article>
                </div>
           
<?php
    } else {
        echo '<div class="container"><p class="mt-5">Post not found.</p></div>';
    }
} else {
    echo '<div class="container"><p class="mt-5">No post title provided.</p></div>';
}

// Close database connection

?>

<h1>More Posts</h1>

    
            <!-- Post Will Fetch Here From Database  -->
            <div class="card">
           
            <?php
            require_once 'includes/post.php';

             ?>
 

            </div>
           
        </div>

        <!-- Sidebar -->
        <div class="sidebar sticky-sidebar">
    <!-- Categories -->
    <div class="card">
        <h3>Categories</h3>
        <ul>
            <?php
            require_once 'includes/config.php';

            // Fetch categories from the database
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display categories
                    echo '<li><a href="#">' . $row["name"] . '</a></li>';
                }
            } else {
                echo "<li>No categories found</li>";
            }

            // Close the database connection
      
            ?>
        </ul>
    </div>



            <!-- Tags -->
            <div class="card">
    <h3>Tags</h3>
    <ul>
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

        // Close the database connection
        mysqli_close($conn);
        ?>
    </ul>
</div>
    </div>
    </div>
    </div>
<footer>
    <p>&copy; Techysandy Blog. - <?php echo date("Y"); ?></p>
</footer>
<script>

const codeArea = document.getElementById('code-area');
const copyIcon = document.querySelector('.copy-icon');

copyIcon.addEventListener('click', async function() {
  try {
    await navigator.clipboard.writeText(codeArea.value);
    copyIcon.style.color = '#2ECC71'; 

    setTimeout(() => {
      copyIcon.style.color = 'white'; 
    }, 1000); 
  } catch (error) {
    console.error("Error copying to clipboard: ", error);
  }
});

codeArea.addEventListener('input', function() {
  this.style.height = 'auto'; 
  this.style.height = this.scrollHeight + 'px'; 
});



</script>
<script>
    // Get all textarea elements on your page
    const textareas = document.querySelectorAll('textarea');

    // Loop through each textarea and set the 'readonly' attribute
    textareas.forEach(textarea => {
      textarea.readOnly = true; 
      textarea.removeAttribute('style');
    });
</script>

</body>
</html>

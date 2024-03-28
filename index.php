<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechySandy Blog.</title>

    <?php
    require_once 'includes/asset.php';
    ?>

    <style>
        /* Add your custom styles here */
    </style>
   
</head>
<body>

<?php
require_once 'includes/header.php';
require_once 'includes/search.php';
require_once 'includes/topbtn.php';
?>

<div class="container">
    <div class="row">
        <div class="main-content">
            <div class="card">
                <!-- Content area -->
                <?php
                // Check if migration is required
                require_once 'includes/config.php';
                function isMigrationRequired() {
                    global $conn;
                    $requiredTables = array('categories', 'posts', 'post_categories', 'post_tags', 'tags');

                    foreach ($requiredTables as $table) {
                        $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
                        if (mysqli_num_rows($result) === 0) {
                            return true;
                        }
                    }

                    return false;
                }

                // If migration is required, show the migrate button
                if (isMigrationRequired()) {
                    // Display the "Migrate Database" button
                    echo '<div style="text-align: center; margin-top: 20px;">';
                    echo '<button id="migrateButton" type="button">Migrate Database</button>';
                    echo '</div>';
                } else {
                    // If migration is not required, display the content
                    require_once 'includes/post.php';
                }
                ?>
            </div>
        </div>
        
        <div class="sidebar sticky-sidebar">
            <!-- Categories -->
            <?php
            if (!isMigrationRequired()) {
                echo '<div class="card">';
                echo '<h3>Categories</h3>';
                echo '<ul>';
                require_once 'includes/cat.php';
                echo '</ul>';
                echo '</div>';
            }
            ?>

            <!-- Tags -->
            <?php
            if (!isMigrationRequired()) {
                echo '<div class="card">';
                echo '<h3>Tags</h3>';
                echo '<ul>';
                require_once 'includes/tag.php';
                echo '</ul>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<footer>
    <p>&copy; Techysandy Blog. - <?php echo date("Y"); ?></p>
    <p>Techysandy.com</p>
</footer>
<script src="admin.js"></script>
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

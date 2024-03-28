<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Posts</title>
    
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
<div class="container">
    <div class="row">
        <!-- Blog content -->
        <div class="main-content">
            <!-- Post Will Fetch Here From Database  -->
            <div class="card">
            <?php
            require_once 'includes/search_cat.php';

             ?>
             <center>
           <h1>More Post</h1>
           </center>
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
            require_once 'includes/cat.php';

             ?>

        </ul>
    </div>



            <!-- Tags -->
            <div class="card">
    <h3>Tags</h3>
    <ul>
    <?php
            require_once 'includes/tag.php';

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

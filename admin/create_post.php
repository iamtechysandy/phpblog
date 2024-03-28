<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Include necessary files
require_once '../includes/config.php';

// Define the destination directory for image uploads
$image_destination = '../uploads/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category']; // Add category

    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        
        // Define the full path for the uploaded image
        $image_destination = $image_destination . $image_name;
        
        if (!move_uploaded_file($image_tmp, $image_destination)) { 
            $error = "Error: Failed to upload image."; // Add error handling
        } else {
            $image = $image_name;
        }
    }

    $tags = explode(",", $_POST['tags']);
    foreach ($tags as $tag_name) {
        $tag_name = trim($tag_name);

        // 1. Check if the tag exists
        $check_tag_sql = "SELECT id FROM tags WHERE name = ?";
        $tag_stmt = $conn->prepare($check_tag_sql);
        $tag_stmt->bind_param("s", $tag_name);
        $tag_stmt->execute();
        $tag_stmt->store_result();

        if ($tag_stmt->num_rows > 0) {
            // Tag exists, get its ID
            $tag_stmt->bind_result($tag_id);
            $tag_stmt->fetch();
        } else {
            // Tag doesn't exist, insert it
            $insert_tag_sql = "INSERT INTO tags (name) VALUES (?)";
            $insert_tag_stmt = $conn->prepare($insert_tag_sql);
            $insert_tag_stmt->bind_param("s", $tag_name);
            $insert_tag_stmt->execute();
            $tag_id = $insert_tag_stmt->insert_id;
        }

        // 2. Link the tag to the post using the relationship table
        $post_tag_sql = "INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)";
        $post_tag_stmt = $conn->prepare($post_tag_sql);
        $post_tag_stmt->bind_param("ii", $post_id, $tag_id);
        $post_tag_stmt->execute();
    }

    // 3. Insert post into database (include category_id)
    $sql = "INSERT INTO posts (title, content, image, category_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $content, $image, $category_id);

    if ($stmt->execute()) {
        // Get the ID of the inserted post
        $post_id = $stmt->insert_id;

        // Insert post categories
        $category_sql = "INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)";
        $category_stmt = $conn->prepare($category_sql);
        $category_stmt->bind_param("ii", $post_id, $category_id);
        $category_stmt->execute();

        header('Location: index.php');
        exit;
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/uee01rwa14jbobji46vq2pkczr8zps73w6le52pvhvocgx1t/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>
<style>
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 1000;
    border: 1px solid #ccc;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 4px;
}

.autocomplete-item {
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.autocomplete-item:hover {
    background-color: #f0f0f0;
}
.ui-helper-hidden-accessible {
    display: none !important;
    }
</style>


<body>
    <div class="container mt-5">
        <h2 class="mb-4">Create New Post</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
  Create Category
</button>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" ></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <select class="form-control" id="category" name="category" required>
        <option value="">Select Category</option>
        <?php
            // Fetch categories from the database
            $categories_sql = "SELECT id, name FROM categories"; 
            $categories_result = $conn->query($categories_sql);
            while ($category = $categories_result->fetch_assoc()) {
                echo "<option value='{$category['id']}'>{$category['name']}</option>"; 
            }
        ?>
    </select>
</div>

<div class="mb-3">
    <label for="tags" class="form-label">Tags (comma-separated)</label>
    <input type="text" class="form-control" id="tags" name="tags">
</div>

            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
    <div id="autocomplete-container"></div>

    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryModalLabel">Create Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form for creating category -->
        <form id="createCategoryForm" action="create_category.php" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Category Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <button type="submit" class="btn btn-primary">Create Category</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(function() {
    $("#tags").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "get_tags.php",
                dataType: "json",
                data: {
                    term: extractLast(request.term)
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 1, // Minimum characters before triggering autocomplete
        select: function(event, ui) {
            var terms = split(this.value);
            terms.pop(); // Remove the current input
            terms.push(ui.item.value); // Add the selected item
            terms.push(""); // Add an empty string to create a space for the next input
            this.value = terms.join(", "); // Join the terms back together
            return false;
        },
        appendTo: "#autocomplete-container", // Specify the container to append the autocomplete dropdown
        messages: {
            noResults: '',
            results: function() {}
        }
    });
});

// Function to split values
function split(val) {
    return val.split(/,\s*/);
}

// Function to extract the last term
function extractLast(term) {
    return split(term).pop();
}
</script>







    <script>
// After form submission, close the modal if successful
document.getElementById('createCategoryForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission
  
  // Fetch form data
  const formData = new FormData(this);

  // Send form data using Fetch API
  fetch(this.action, {
    method: this.method,
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    // Display success message or error
    alert(data);

    // If successful, close the modal
    if (data.includes("successfully")) {
      const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
      modal.hide();
    }
  })
  .catch(error => console.error('Error:', error));
});

</script>
    <script>
    tinymce.init({
        selector: '#content',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Sandeep Kushwaha',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        
        // Configure image upload handler
        images_upload_url: 'upload.php',
        images_upload_handler: function (blobInfo, success, failure) {
    const formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP Error: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (!data || typeof data.location !== 'string') {
            throw new Error('Invalid JSON: ' + JSON.stringify(data));
        }
        success(data.location);
    })
    .catch(error => {
        failure(error.message);
    });
}
    });
</script>

</body>
</html>

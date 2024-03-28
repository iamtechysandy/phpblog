<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Include necessary files
require_once '../includes/config.php';
require_once '../includes/fun.php';

// Fetch all posts from the database
$posts = getAllPosts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 20px;
            cursor: pointer; /* Change cursor to pointer when hovering over the card */
            transition: transform 0.3s ease; /* Add transition effect for smooth hover animation */
            position: relative; /* Position relative for absolute positioning of tooltip */
        }
        .card:hover {
            transform: translateY(-5px); /* Move card up slightly on hover */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Add shadow effect on hover */
        }
        .card-img-top {
            object-fit: cover;
            height: 300px; /* Set image height */
        }
        .card-text a {
            color: inherit; /* Use the default text color for links */
            text-decoration: none; /* Remove underline style */
        }
        .tooltip {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px;
            border-radius: 5px;
            display: none; /* Initially hide the tooltip */
            pointer-events: none; /* Ensure tooltip doesn't interfere with hover */
        }
        .card:hover .tooltip {
            display: block; /* Display tooltip on hover */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Admin Dashboard</h2>
        <a href="create_post.php" class="btn btn-success mb-3">Create New Post</a>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($posts as $post) { ?>
                <div class="col">
                    <a href="../post.php?title=<?php echo urlencode($post['title']); ?>" target="_blank" class="text-decoration-none"> <!-- Remove default underline style -->
                        <div class="card">
                            <?php if (!empty($post['image'])) { ?>
                                <img src="../uploads/<?php echo $post['image']; ?>" class="card-img-top" alt="Post Image">
                            <?php } else { ?>
                                <img src="https://placehold.co/600x400?text=No+Image" class="card-img-top" alt="No Image">
                            <?php } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $post['title']; ?></h5>
                                <p class="card-text"><?php echo substr($post['content'], 0, 100); ?>...</p>
                                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Edit</a>
                                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger">Delete</a>
                            </div>
                            <div class="tooltip">Tooltip Text</div> <!-- Tooltip -->
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<script>
const cards = document.querySelectorAll('.card');

cards.forEach(card => {
    card.addEventListener('mousemove', e => {
        const tooltip = card.querySelector('.tooltip');
        const x = e.clientX;
        const y = e.clientY;
        tooltip.style.left = x + 'px';
        tooltip.style.top = y + 'px';
    });
});
</script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

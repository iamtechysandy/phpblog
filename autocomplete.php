<?php
require_once 'includes/config.php';

if (isset($_GET['term'])) {
  $term = $_GET['term'];

  // Prepared statement for security
  $stmt = $conn->prepare("SELECT DISTINCT title FROM posts WHERE title LIKE ? ORDER BY title ASC");
  $stmt->bind_param("s", "%$term%");  
  $stmt->execute();
  $result = $stmt->get_result();

  $data = array();
  while ($row = $result->fetch_assoc()) {
    $data[] = $row['title'];
  }

  echo json_encode($data);
}
?>

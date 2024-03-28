<?php
// Include necessary files
require_once '../includes/config.php';

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Fetch tags from the database based on the user input
    $sql = "SELECT name FROM tags WHERE name LIKE ? ORDER BY name ASC";
    $stmt = $conn->prepare($sql);
    $search_term = '%' . $term . '%';
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    $tags = array();
    while ($row = $result->fetch_assoc()) {
        $tags[] = $row['name'];
    }

    echo json_encode($tags);
}
?>

<?php
// Include the database configuration file
include 'includes/config.php';

// Function to migrate the database schema
function migrateDatabase() {
    global $conn;

    // SQL queries to create tables
    $sql = "
        CREATE TABLE IF NOT EXISTS `categories` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

        CREATE TABLE IF NOT EXISTS `posts` (
            `id` int NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `content` text NOT NULL,
            `image` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

        CREATE TABLE IF NOT EXISTS `post_categories` (
            `post_id` int DEFAULT NULL,
            `category_id` int DEFAULT NULL,
            KEY `post_id` (`post_id`),
            KEY `category_id` (`category_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

        CREATE TABLE IF NOT EXISTS `post_tags` (
            `post_id` int DEFAULT NULL,
            `tag_id` int DEFAULT NULL,
            KEY `post_id` (`post_id`),
            KEY `tag_id` (`tag_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

        CREATE TABLE IF NOT EXISTS `tags` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    ";

    // Execute the SQL queries
    if (mysqli_multi_query($conn, $sql)) {
        echo "Hurrah Migration successful!";
    } else {
        echo "Error creating tables: " . mysqli_error($conn);
    }
}

// Function to check if migration is required
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

// Check if migration is required and perform migration if needed
if (isMigrationRequired()) {
    migrateDatabase();
} else {
    echo "Database schema is up to date.";
}

// Close the database connection
mysqli_close($conn);
?>

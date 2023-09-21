<?php
include 'config.php';

if (isset($_GET['category_id'])) {
    $categoryID = $_GET['category_id'];

    // Prepare the SQL statement
    $sql = "SELECT id, name FROM subcategory WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryID);

    // Execute the query
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $subcategories = [];

        while ($row = $result->fetch_assoc()) {
            $subcategories[] = $row;
        }

        // Return subcategories as JSON
        header('Content-Type: application/json');
        echo json_encode($subcategories);
    } else {
        echo 'Error executing query';
    }
} else {
    echo 'Invalid request';
}

<?php

session_start();
include("../includes/connection.php");

if (isset($_GET['id'])) {
    // Using prepared statement to prevent SQL injection
    $query = "DELETE FROM category WHERE cat_id = ?";
    
    $stmt = mysqli_prepare($link, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        
        header("location: category_view.php");
        exit();
    } else {
        // Handle the error if the prepared statement fails
        echo "Error in prepared statement: " . mysqli_error($link);
    }
} else {
    // Handle the case where 'id' is not set
    echo "Category ID not provided.";
}

?>

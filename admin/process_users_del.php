<?php
session_start();

include("../includes/connection.php");

if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];

    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM register WHERE r_id = ?";
    
    $stmt = mysqli_prepare($link, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location:users.php");
    } else {
        // Handle the case where the prepared statement fails
        echo "Failed to delete user.";
    }
} else {
    echo "Invalid user ID.";
}
?>

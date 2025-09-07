<?php
session_start();

include("../includes/connection.php");

if (isset($_GET['id'])) {
    $contactId = (int)$_GET['id'];

    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM contact WHERE c_id = ?";
    
    $stmt = mysqli_prepare($link, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $contactId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location:contact_view.php");
    } else {
        // Handle the case where the prepared statement fails
        echo "Failed to delete contact.";
    }
} else {
    echo "Invalid contact ID.";
}
?>

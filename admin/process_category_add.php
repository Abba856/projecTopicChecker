<?php
session_start();

if (!empty($_POST)) {
    $_SESSION['error'] = array();
    extract($_POST);

    // Sanitize user input to prevent SQL injection
    $cat = htmlspecialchars(strip_tags($cat));

    if (empty($cat)) {
        $_SESSION['error']['cat'] = "Please Enter Category Name";
    }

    if (!empty($_SESSION['error']['cat'])) {
        // Store the error in a session variable and redirect to the form
        $_SESSION['error_message'] = "Category addition failed. Please fix the errors.";
        header("location:category_add.php");
    } else {
        include("../includes/connection.php");

        // Use prepared statements to prevent SQL injection
        $stmt = $link->prepare("INSERT INTO category (cat_nm) VALUES (?)");
        $stmt->bind_param("s", $cat);
        $stmt->execute();
        $stmt->close();

        // Provide a success message
        $_SESSION['success_message'] = "Category added successfully.";

        header("location:category_add.php");
    }
} else {
    header("location:category.php");
}
?>

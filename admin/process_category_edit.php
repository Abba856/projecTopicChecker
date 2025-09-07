<?php
session_start();

if (!empty($_POST)) {
    extract($_POST);
    $_SESSION['error'] = array();

    if (empty($cat)) {
        $_SESSION['error'][] = "Please enter Category Name";
        header("location:category_edit.php?id=$id");
    } else {
        include("../includes/connection.php");

        // Switching to MySQLi and using prepared statement
        $q = "UPDATE category SET cat_nm=? WHERE cat_id=?";
        $stmt = mysqli_prepare($link, $q);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $cat, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("location:category_view.php");
        } else {
            // Handle the case where the prepared statement fails
            $_SESSION['error'][] = "Failed to update category";
            header("location:category_edit.php?id=$id");
        }
    }
} else {
    header("location:category_view.php");
}
?>

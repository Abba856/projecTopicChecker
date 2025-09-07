<?php

session_start();

include("../includes/connection.php");

if (!empty($_POST)) {
    $_SESSION['error'] = array();

    // Sanitize user input to prevent SQL injection
    $bnm = htmlspecialchars(strip_tags($_POST['bnm']));
    $cat = intval($_POST['cat']); // Convert to integer to prevent SQL injection
    $desc = htmlspecialchars(strip_tags($_POST['desc']));
    $price = floatval($_POST['price']);

    // File upload validation
    if (empty($_FILES['b_img']['name'])) {
        $_SESSION['error']['b_img'] = "Please provide a file";
    } elseif ($_FILES['b_img']['error'] > 0) {
        $_SESSION['error']['b_img'] = "Error uploading file";
    } elseif (!(strtoupper(substr($_FILES['b_img']['name'], -4)) == ".JPG" || strtoupper(substr($_FILES['b_img']['name'], -5)) == ".JPEG" || strtoupper(substr($_FILES['b_img']['name'], -4)) == ".GIF")) {
        $_SESSION['error']['b_img'] = "Wrong file type";
    } elseif (!getimagesize($_FILES['b_img']['tmp_name'])) {
        $_SESSION['error']['b_img'] = "Invalid image file";
    }

    if (!empty($_SESSION['error'])) {
        header("location: book_add.php");
    } else {
        $t = time();
        move_uploaded_file($_FILES['b_img']['tmp_name'], "../book_img/" . $_FILES['b_img']['name']);
        $b_img = "book_img/" . $_FILES['b_img']['name'];

        // Using prepared statement to prevent SQL injection
        $query = "INSERT INTO book (b_nm, b_cat, b_desc, b_price, b_img, b_time) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sissis", $bnm, $cat, $desc, $price, $b_img, $t);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("location: book_add.php");
            exit();
        } else {
            // Handle the error if the prepared statement fails
            echo "Error in prepared statement: " . mysqli_error($link);
        }
    }
} else {
    header("location: book_add.php");
}

?>

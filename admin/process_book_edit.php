<?php
session_start();

if (!empty($_POST)) {
    $_SESSION['error'] = array();
    extract($_POST);
	include("../includes/connection.php");
    // Sanitize user input to prevent SQL injection
    $bnm = htmlspecialchars(strip_tags($bnm));
    $desc = htmlspecialchars(strip_tags($desc));
    $price = floatval($price);

    // File upload validation
    if (empty($_FILES['b_img']['name'])) {
        $_SESSION['error']['b_img'] = "Please provide a file";
    } elseif ($_FILES['b_img']['error'] > 0) {
        $_SESSION['error']['b_img'] = "Error uploading file";
    } elseif (!(strtoupper(pathinfo($_FILES['b_img']['name'], PATHINFO_EXTENSION)) == "JPG" || strtoupper(pathinfo($_FILES['b_img']['name'], PATHINFO_EXTENSION)) == "JPEG" || strtoupper(pathinfo($_FILES['b_img']['name'], PATHINFO_EXTENSION)) == "GIF")) {
        $_SESSION['error']['b_img'] = "Wrong file type";
    } elseif (!getimagesize($_FILES['b_img']['tmp_name'])) {
        $_SESSION['error']['b_img'] = "Invalid image file";
    }

    if (!empty($_SESSION['error'])) {
        header("location: book_edit.php?id=" . $id);
    } else {
        include("../includes/connection.php");

        // Create a connection
        $conn = new mysqli($host, $username, $password, $database);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $t = time();
        move_uploaded_file($_FILES['b_img']['tmp_name'], "../book_img/" . $_FILES['b_img']['name']);
        $b_img = "book_img/" . $_FILES['b_img']['name'];

        // Prepare and execute the query
        $stmt = $conn->prepare("UPDATE book SET b_nm=?, b_cat=?, b_desc=?, b_price=?, b_img=?, b_time=? WHERE b_id=?");
        $stmt->bind_param("sssdssi", $bnm, $cat, $desc, $price, $b_img, $t, $id);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        header("location: book_view.php");
    }
} else {
    header("location: book_view.php");
}
?>

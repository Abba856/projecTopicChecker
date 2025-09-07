<?php
session_start();

include("includes/connection.php");

if (!empty($_POST)) {
    $_SESSION['error'] = array();
    extract($_POST);

    if (empty($unm)) {
        $_SESSION['error']['unm'] = "Please enter User Name";
    }

    if (empty($pwd) || empty($cpwd)) {
        $_SESSION['error']['pwd'] = "Please enter New Password";
    } elseif ($pwd != $cpwd) {
        $_SESSION['error']['pwd'] = "Password isn't Match";
    } elseif (strlen($pwd) < 8) {
        $_SESSION['error']['pwd'] = "Please Enter Minimum 8 Digit Password";
    }

    if (empty($answer)) {
        $_SESSION['error']['answer'] = "Please enter Security Answer";
    }

    // Check if username exists
    $row = null;
    if (!empty($unm)) {
        $q = "SELECT * FROM register WHERE r_unm = ?";
        $stmt = $link->prepare($q);
        $stmt->bind_param("s", $unm);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        
        if (empty($row)) {
            $_SESSION['error']['unm'] = "Wrong User Name";
        }
    }

    if (!empty($_SESSION['error'])) {
        header("location:forget_password.php");
        exit();
    } else {
        // Check if security answer matches
        if ($row && $answer != $row['r_answer']) {
            $_SESSION['error']['answer'] = "Wrong Security Answer";
            header("location:forget_password.php");
            exit();
        }
        
        // Reset the password here
        // Update the user's password in the database
        $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE register SET r_pwd = ? WHERE r_unm = ?";
        $stmt = $link->prepare($updateQuery);
        $stmt->bind_param("ss", $hashedPassword, $unm);
        $updateResult = $stmt->execute();

        if ($updateResult) {
            echo "Password updated successfully.";
        } else {
            $_SESSION['error'][] = "Error updating the password.";
            header("location:forget_password.php");
            exit();
        }
    }
} else {
    header("location:forget_password.php");
    exit();
}
?>

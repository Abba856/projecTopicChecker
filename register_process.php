<?php
session_start();

if (!empty($_POST)) {
    extract($_POST);
    $_SESSION['error'] = array();

    if (empty($fnm)) {
        $_SESSION['error']['fnm'] = "Please enter Full Name";
    }

    if (empty($unm)) {
        $_SESSION['error']['unm'] = "Please enter User Name";
    }

    if (empty($pwd) || empty($cpwd)) {
        $_SESSION['error']['pwd'] = "Please enter Password";
    } elseif ($pwd != $cpwd) {
        $_SESSION['error']['pwd'] = "Password isn't Match";
    } elseif (strlen($pwd) < 8) {
        $_SESSION['error']['pwd'] = "Please Enter Minimum 8 Digit Password";
    }

    if (empty($email)) {
        $_SESSION['error']['email'] = "Please enter E-Mail Address";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error']['email'] = "Please Enter Valid E-Mail Address";
    }

    if (empty($answer)) {
        $_SESSION['error']['answer'] = "Please Enter Security Answer";
    }

    if (empty($cno)) {
        $_SESSION['error']['cno'] = "Please Contact Number";
    }
    if (!empty($cno) && !is_numeric($cno)) {
        $_SESSION['error']['cno'] = "Please Enter Contact Number in Numbers";
    }

    if (!empty($_SESSION['error'])) {
        header("location:register.php");
        exit();
    } else {
        include("includes/connection.php");

        $t = time();
        
        // Hash the password for security
        $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $q = "INSERT INTO register(r_fnm, r_unm, r_pwd, r_cno, r_email, r_question, r_answer, r_time) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $link->prepare($q);
        $stmt->bind_param("sssssssi", $fnm, $unm, $hashedPassword, $cno, $email, $question, $answer, $t);

        if ($stmt->execute()) {
            header("location:register.php?register");
        } else {
            // Handle query error
            $_SESSION['error'][] = "Error executing the query.";
            header("location:register.php");
        }
        exit();
    }
} else {
    header("location:register.php");
    exit();
}
?>

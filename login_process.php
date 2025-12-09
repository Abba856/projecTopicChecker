<?php
session_start();

if (!empty($_POST)) {
    $unm = isset($_POST['unm']) ? trim($_POST['unm']) : '';
    $pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
    
    $_SESSION['error'] = array();

    if (empty($unm) || empty($pwd)) {
        $_SESSION['error'][] = "Please enter User Name or Password";
        header("location:login.php");
        exit();
    } else {
        include("includes/connection.php");

        // Use prepared statement to prevent SQL injection
        $q = "SELECT * FROM register WHERE r_unm = ?";
        $stmt = $link->prepare($q);
        $stmt->bind_param("s", $unm);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res) {
            $row = $res->fetch_assoc();

            if (!empty($row) && password_verify($pwd, $row['r_pwd'])) {
                $_SESSION['client']['unm'] = $row['r_fnm'];
                $_SESSION['client']['id'] = $row['r_id'];
                $_SESSION['client']['status'] = true;

                header("location:index.php");
                exit();
            } else {
                $_SESSION['error'][] = "Wrong Username or Password";
                header("location:login.php");
                exit();
            }
        } else {
            // Handle query error
            $_SESSION['error'][] = "Error executing the query.";
            header("location:login.php");
            exit();
        }
    }
} else {
    header("location:login.php");
    exit();
}
?>

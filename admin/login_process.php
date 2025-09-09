<?php
session_start();

include("../includes/connection.php");

// Create a simple admin table if it doesn't exist
$createAdminTable = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$link->query($createAdminTable);

// Insert default admin user if it doesn't exist
$checkAdmin = "SELECT COUNT(*) as count FROM admin WHERE username = 'admin'";
$result = $link->query($checkAdmin);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    // Insert default admin user (password: admin123)
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $insertAdmin = "INSERT INTO admin (username, password) VALUES ('admin', '$hashedPassword')";
    $link->query($insertAdmin);
}

if (!empty($_POST)) {
    $_SESSION['error'] = array();
    extract($_POST);

    if (empty($unm) || empty($pwd)) {
        $_SESSION['error'][] = "Please enter both username and password";
        header("location:login_new.php");
        exit();
    } else {
        // Use prepared statement to prevent SQL injection
        $q = "SELECT * FROM admin WHERE username = ?";
        $stmt = $link->prepare($q);
        $stmt->bind_param("s", $unm);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res) {
            $row = $res->fetch_assoc();

            if (!empty($row) && password_verify($pwd, $row['password'])) {
                $_SESSION['admin']['username'] = $row['username'];
                $_SESSION['admin']['status'] = true;
                header("location:dashboard_modern.php");
                exit();
            } else {
                $_SESSION['error'][] = "Invalid username or password";
                header("location:login_new.php");
                exit();
            }
        } else {
            $_SESSION['error'][] = "Error authenticating. Please try again.";
            header("location:login_new.php");
            exit();
        }
    }
} else {
    header("location:login_new.php");
    exit();
}
?>
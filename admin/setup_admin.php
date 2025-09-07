<?php
// Database setup script for admin panel
include("../includes/connection.php");

// Create admin table if it doesn't exist
$createAdminTable = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($link->query($createAdminTable) === TRUE) {
    echo "Admin table created successfully or already exists.\n";
} else {
    echo "Error creating admin table: " . $link->error . "\n";
}

// Check if admin table exists and has data
$checkAdminTable = "SHOW TABLES LIKE 'admin'";
$result = $link->query($checkAdminTable);

if ($result && $result->num_rows > 0) {
    // Check if there are any admin users
    $checkAdmin = "SELECT COUNT(*) as count FROM admin";
    $result = $link->query($checkAdmin);
    
    if ($result) {
        $row = $result->fetch_assoc();
        
        if ($row && $row['count'] == 0) {
            // Insert default admin user (password: admin123)
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $insertAdmin = "INSERT INTO admin (username, password) VALUES ('admin', ?)";
            $stmt = $link->prepare($insertAdmin);
            $stmt->bind_param("s", $hashedPassword);
            
            if ($stmt->execute()) {
                echo "Default admin user created successfully.\n";
                echo "Username: admin\n";
                echo "Password: admin123 (please change this after first login)\n";
            } else {
                echo "Error creating default admin user: " . $stmt->error . "\n";
            }
        } else {
            echo "Admin users already exist.\n";
            // Check if passwords are properly hashed
            $checkPasswords = "SELECT id, username, password FROM admin";
            $result = $link->query($checkPasswords);
            
            if ($result) {
                while ($admin = $result->fetch_assoc()) {
                    // Check if password looks like a hash (starts with $)
                    if (strpos($admin['password'], '$') !== 0) {
                        // Password is not hashed, hash it
                        $hashedPassword = password_hash($admin['password'], PASSWORD_DEFAULT);
                        $updatePassword = "UPDATE admin SET password = ? WHERE id = ?";
                        $stmt = $link->prepare($updatePassword);
                        $stmt->bind_param("si", $hashedPassword, $admin['id']);
                        
                        if ($stmt->execute()) {
                            echo "Password for user '" . $admin['username'] . "' hashed successfully.\n";
                        } else {
                            echo "Error hashing password for user '" . $admin['username'] . "': " . $stmt->error . "\n";
                        }
                    }
                }
            }
        }
    } else {
        echo "Error checking admin users: " . $link->error . "\n";
    }
} else {
    echo "Admin table does not exist or error checking table.\n";
}

echo "Admin setup completed successfully!\n";
?>
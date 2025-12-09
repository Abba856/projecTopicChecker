<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']['status'])) {
    header("location:login_new.php");
    exit();
}

include("../includes/connection.php");

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    $stmt = $link->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['admin']['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    
    if ($admin && password_verify($current_password, $admin['password'])) {
        // Check if new passwords match
        if ($new_password === $confirm_password) {
            // Check password length
            if (strlen($new_password) >= 6) {
                // Update password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $link->prepare("UPDATE admin SET password = ? WHERE username = ?");
                $stmt->bind_param("ss", $hashed_password, $_SESSION['admin']['username']);
                $stmt->execute();
                $_SESSION['message'] = "Password updated successfully!";
            } else {
                $_SESSION['error'] = "New password must be at least 6 characters long.";
            }
        } else {
            $_SESSION['error'] = "New passwords do not match.";
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect.";
    }
    
    header("location:settings.php");
    exit();
}

// Handle profile update
if (isset($_POST['update_profile'])) {
    $new_username = trim($_POST['new_username']);
    
    // Validate input
    if (!empty($new_username)) {
        // Check if username already exists (excluding current user)
        $stmt = $link->prepare("SELECT COUNT(*) as count FROM admin WHERE username = ? AND username != ?");
        $stmt->bind_param("ss", $new_username, $_SESSION['admin']['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            $_SESSION['error'] = "Username already exists.";
        } else {
            // Update username
            $stmt = $link->prepare("UPDATE admin SET username = ? WHERE username = ?");
            $stmt->bind_param("ss", $new_username, $_SESSION['admin']['username']);
            $stmt->execute();
            $_SESSION['admin']['username'] = $new_username;
            $_SESSION['message'] = "Profile updated successfully!";
        }
    } else {
        $_SESSION['error'] = "Username cannot be empty.";
    }
    
    header("location:settings.php");
    exit();
}

// Get system statistics
$topics_count = 0;
$users_count = 0;
$messages_count = 0;

$stmt = $link->prepare("SELECT COUNT(*) as count FROM topics");
$stmt->execute();
$result = $stmt->get_result();
$topics_count = $result->fetch_assoc()['count'];

$stmt = $link->prepare("SELECT COUNT(*) as count FROM register");
$stmt->execute();
$result = $stmt->get_result();
$users_count = $result->fetch_assoc()['count'];

$stmt = $link->prepare("SELECT COUNT(*) as count FROM contact");
$stmt->execute();
$result = $stmt->get_result();
$messages_count = $result->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5a6fd8;
            --secondary: #764ba2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --light: #f8f9fa;
            --dark: #1e293b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-600: #718096;
            --gray-800: #1e293b;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            color: var(--gray-800);
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h1 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-header p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin: 5px 0 0 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.85);
            transition: all 0.3s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 3px solid white;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px;
            background: rgba(0, 0, 0, 0.2);
            border: none;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .admin-header {
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-title h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
        }

        .header-title p {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin: 3px 0 0 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-details {
            text-align: right;
        }

        .user-details .name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .user-details .role {
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gray-800);
            margin: 0;
        }

        /* Settings Grid */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .setting-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
        }

        .setting-card h3 {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0 0 25px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--gray-800);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: var(--gray-800);
        }

        .stat-label {
            font-size: 1rem;
            color: var(--gray-600);
            margin: 0;
        }

        /* Message Styles */
        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .message.success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border-left: 4px solid #059669;
        }

        .message.error {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .menu-toggle-btn {
            background: var(--primary);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .menu-toggle-btn:hover {
            background: var(--primary-dark);
        }

        /* Responsive Design */
        @media (max-width: 1199px) {
            .activity-section {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
                z-index: 1001;
                position: fixed;
                top: 0;
                height: 100vh;
                transition: transform 0.3s ease;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .settings-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-content {
                padding: 20px;
            }
            
            .admin-header {
                padding: 0 15px;
                height: 60px;
            }
            
            .header-title h1 {
                font-size: 1.2rem;
            }
            
            .header-title p {
                font-size: 0.8rem;
            }
            
            .user-info {
                gap: 10px;
            }
            
            .user-avatar {
                width: 30px;
                height: 30px;
                font-size: 0.85rem;
            }
            
            .user-details {
                display: none;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .form-group label {
                font-size: 0.9rem;
            }
            
            .btn {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .section-header h2 {
                font-size: 1.1rem;
            }
            
            .view-all {
                font-size: 0.85rem;
            }
            
            .activity-item {
                flex-direction: column;
                gap: 10px;
            }
            
            .activity-icon {
                width: 35px;
                height: 35px;
                align-self: flex-start;
            }
            
            .activity-desc {
                font-size: 0.85rem;
            }
            
            .activity-time {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .setting-card {
                padding: 20px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .activity-item {
                flex-direction: column;
                gap: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .dashboard-content {
                padding: 15px;
            }
            
            .admin-header {
                padding: 0 10px;
            }
            
            .activity-title {
                font-size: 1rem;
            }
            
            .activity-desc {
                font-size: 0.8rem;
            }
            
            .btn {
                padding: 9px 12px;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 360px) {
            .activity-icon {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }
            
            .activity-title {
                font-size: 0.95rem;
            }
            
            .btn {
                padding: 8px 10px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <h1>Project Topic Checker</h1>
            <p>Admin Dashboard</p>
        </div>
        
        <nav class="sidebar-menu">
            <a href="dashboard_modern.php" class="menu-item">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            <a href="topics.php" class="menu-item">
                <i class="fas fa-book"></i>
                Manage Topics
            </a>
            <a href="users.php" class="menu-item">
                <i class="fas fa-users"></i>
                Manage Users
            </a>
            <a href="messages.php" class="menu-item">
                <i class="fas fa-envelope"></i>
                Messages
            </a>
            <a href="report.php" class="menu-item">
                <i class="fas fa-chart-bar"></i>
                Reports
            </a>
            <a href="settings.php" class="menu-item active">
                <i class="fas fa-cog"></i>
                Settings
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <button class="logout-btn" onclick="window.location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-title">
                <h1>Settings</h1>
                <p>Manage your admin account</p>
            </div>
            
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo substr($_SESSION['admin']['username'], 0, 1); ?>
                </div>
                <div class="user-details">
                    <div class="name"><?php echo htmlspecialchars($_SESSION['admin']['username']); ?></div>
                    <div class="role">Administrator</div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Admin Settings</h1>
            </div>

            <!-- Display Messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message success">
                    <i class="fas fa-check-circle"></i> <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Settings Grid -->
            <div class="settings-grid">
                <!-- Change Password -->
                <div class="setting-card">
                    <h3><i class="fas fa-lock"></i> Change Password</h3>
                    
                    <form method="POST" action="">
                        <input type="hidden" name="change_password" value="1">
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter your current password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter your new password" required minlength="6">
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm your new password" required minlength="6">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Password
                        </button>
                    </form>
                </div>
                
                <!-- Update Profile -->
                <div class="setting-card">
                    <h3><i class="fas fa-user-edit"></i> Update Profile</h3>
                    
                    <form method="POST" action="">
                        <input type="hidden" name="update_profile" value="1">
                        
                        <div class="form-group">
                            <label for="new_username">Username</label>
                            <input type="text" id="new_username" name="new_username" class="form-control" placeholder="Enter new username" value="<?php echo htmlspecialchars($_SESSION['admin']['username']); ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- System Statistics -->
            <h3 style="color: var(--gray-800); font-size: 1.5rem; font-weight: 600; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-chart-bar"></i> System Statistics
            </h3>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-number"><?php echo $topics_count; ?></div>
                    <p class="stat-label">Project Topics</p>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number"><?php echo $users_count; ?></div>
                    <p class="stat-label">Registered Users</p>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-number"><?php echo $messages_count; ?></div>
                    <p class="stat-label">Contact Messages</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            let isMobileMenuOpen = false;
            
            // Add menu toggle button to header
            const header = document.querySelector('.admin-header');
            const toggleButton = document.createElement('button');
            toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
            toggleButton.className = 'menu-toggle-btn';
            
            // Add the toggle button to the header
            const headerTitle = header.querySelector('.header-title');
            header.insertBefore(toggleButton, headerTitle);
            
            // Show toggle button on mobile
            function checkMobileView() {
                if (window.innerWidth <= 992) {
                    toggleButton.style.display = 'flex';
                    // On mobile, sidebar should be hidden by default
                    if (!isMobileMenuOpen) {
                        sidebar.style.transform = 'translateX(-100%)';
                    }
                } else {
                    toggleButton.style.display = 'none';
                    sidebar.style.transform = 'translateX(0)'; // Show sidebar on desktop
                }
            }
            
            // Initial check
            checkMobileView();
            
            // Check on resize
            window.addEventListener('resize', checkMobileView);
            
            // Toggle menu
            toggleButton.addEventListener('click', function() {
                isMobileMenuOpen = !isMobileMenuOpen;
                
                // Apply transform to the entire sidebar
                sidebar.style.transform = isMobileMenuOpen ? 'translateX(0)' : 'translateX(-100%)';
                
                // Change icon based on state
                toggleButton.innerHTML = isMobileMenuOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
                
                // Add backdrop when menu is open
                if (isMobileMenuOpen) {
                    const backdrop = document.createElement('div');
                    backdrop.className = 'mobile-backdrop';
                    backdrop.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.5);
                        z-index: 1000;
                        display: block;
                    `;
                    
                    backdrop.addEventListener('click', function() {
                        isMobileMenuOpen = false;
                        sidebar.style.transform = 'translateX(-100%)';
                        toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
                        document.body.removeChild(backdrop);
                    });
                    
                    document.body.appendChild(backdrop);
                }
            });
        });
    </script>
</body>
</html>

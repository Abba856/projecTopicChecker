<?php
session_start();
// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin']['status'] !== true) {
    header("Location: login.php");
    exit();
}

include("../includes/connection.php");

// Get counts for dashboard statistics
$topic_count = 0;
$user_count = 0;
$pending_count = 0;
$accepted_count = 0;
$rejected_count = 0;

// Get topic count
$topic_q = "SELECT COUNT(*) as count FROM topics";
$topic_res = $link->query($topic_q);
if ($topic_res) {
    $topic_row = $topic_res->fetch_assoc();
    $topic_count = $topic_row['count'];
}

// Get user count
$user_q = "SELECT COUNT(*) as count FROM register";
$user_res = $link->query($user_q);
if ($user_res) {
    $user_row = $user_res->fetch_assoc();
    $user_count = $user_row['count'];
}

// Get pending topics count
$pending_q = "SELECT COUNT(*) as count FROM topics WHERE status = 'available'";
$pending_res = $link->query($pending_q);
if ($pending_res) {
    $pending_row = $pending_res->fetch_assoc();
    $pending_count = $pending_row['count'];
}

// Get accepted topics count
$accepted_q = "SELECT COUNT(*) as count FROM topics WHERE status = 'taken'";
$accepted_res = $link->query($accepted_q);
if ($accepted_res) {
    $accepted_row = $accepted_res->fetch_assoc();
    $accepted_count = $accepted_row['count'];
}

// Get rejected topics count
$rejected_q = "SELECT COUNT(*) as count FROM topics WHERE status = 'completed'";
$rejected_res = $link->query($rejected_q);
if ($rejected_res) {
    $rejected_row = $rejected_res->fetch_assoc();
    $rejected_count = $rejected_row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Project Topic Checker</title>
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

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .welcome-banner h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .welcome-banner p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
            max-width: 600px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
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
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }

        .stat-icon.red {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
        }

        .stat-title {
            font-size: 1rem;
            color: var(--gray-600);
            font-weight: 500;
            margin: 0 0 10px 0;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 5px 0;
            color: var(--gray-800);
        }

        .stat-trend {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-trend.up {
            color: var(--success);
        }

        .stat-trend.down {
            color: var(--danger);
        }

        /* Recent Activity */
        .activity-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .recent-activity, .quick-actions {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
            color: var(--gray-800);
        }

        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .activity-icon.blue {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
        }

        .activity-icon.green {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .activity-icon.orange {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin: 0 0 5px 0;
            color: var(--gray-800);
        }

        .activity-desc {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin: 0 0 8px 0;
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .action-buttons {
            display: grid;
            gap: 12px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .action-btn.primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
        }

        .action-btn.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .action-btn.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .action-btn.danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .activity-section {
                grid-template-columns: 1fr;
            }
            
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .dashboard-content {
                padding: 20px;
            }
            
            .admin-header {
                padding: 0 20px;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-banner h1 {
                font-size: 1.5rem;
            }
            
            .welcome-banner p {
                font-size: 1rem;
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
            <a href="dashboard_modern.php" class="menu-item active">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            <a href="topics_manage.php" class="menu-item">
                <i class="fas fa-book"></i>
                Manage Topics
            </a>
            <a href="users_manage.php" class="menu-item">
                <i class="fas fa-users"></i>
                Manage Users
            </a>
            <a href="topics_submitted.php" class="menu-item">
                <i class="fas fa-upload"></i>
                Submitted Topics
            </a>
            <a href="reports.php" class="menu-item">
                <i class="fas fa-chart-bar"></i>
                Reports
            </a>
            <a href="settings.php" class="menu-item">
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
                <h1>Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['admin']['unm']); ?>!</p>
            </div>
            
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo substr($_SESSION['admin']['unm'], 0, 1); ?>
                </div>
                <div class="user-details">
                    <div class="name"><?php echo htmlspecialchars($_SESSION['admin']['unm']); ?></div>
                    <div class="role">Administrator</div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="welcome-banner">
                <h1>Admin Dashboard</h1>
                <p>Manage project topics, users, and submissions with our modern admin panel.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-title">Total Topics</div>
                    <div class="stat-value"><?php echo $topic_count; ?></div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i>
                        12% from last month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value"><?php echo $user_count; ?></div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i>
                        8% from last month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-title">Pending Topics</div>
                    <div class="stat-value"><?php echo $pending_count; ?></div>
                    <div class="stat-trend down">
                        <i class="fas fa-arrow-down"></i>
                        3% from last month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-title">Accepted Topics</div>
                    <div class="stat-value"><?php echo $accepted_count; ?></div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i>
                        15% from last month
                    </div>
                </div>
            </div>

            <!-- Recent Activity and Quick Actions -->
            <div class="activity-section">
                <div class="recent-activity">
                    <div class="section-header">
                        <h2><i class="fas fa-history"></i> Recent Activity</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-icon blue">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="activity-content">
                                <h3 class="activity-title">New Topic Added</h3>
                                <p class="activity-desc">"Online Examination System" was added to the database</p>
                                <span class="activity-time">2 hours ago</span>
                            </div>
                        </li>
                        
                        <li class="activity-item">
                            <div class="activity-icon green">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-content">
                                <h3 class="activity-title">Topic Accepted</h3>
                                <p class="activity-desc">"Student Result Management System" status changed to accepted</p>
                                <span class="activity-time">5 hours ago</span>
                            </div>
                        </li>
                        
                        <li class="activity-item">
                            <div class="activity-icon orange">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-content">
                                <h3 class="activity-title">New User Registered</h3>
                                <p class="activity-desc">User "john_doe" registered for the system</p>
                                <span class="activity-time">1 day ago</span>
                            </div>
                        </li>
                        
                        <li class="activity-item">
                            <div class="activity-icon red">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="activity-content">
                                <h3 class="activity-title">Topic Rejected</h3>
                                <p class="activity-desc">"PHP Casino" was rejected due to inappropriate content</p>
                                <span class="activity-time">2 days ago</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="quick-actions">
                    <div class="section-header">
                        <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="topics_manage.php" class="action-btn primary">
                            <i class="fas fa-book"></i>
                            Manage Topics
                        </a>
                        
                        <a href="users_manage.php" class="action-btn success">
                            <i class="fas fa-users"></i>
                            Manage Users
                        </a>
                        
                        <a href="topics_submitted.php" class="action-btn warning">
                            <i class="fas fa-upload"></i>
                            View Submissions
                        </a>
                        
                        <a href="reports.php" class="action-btn danger">
                            <i class="fas fa-chart-bar"></i>
                            Generate Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Add any JavaScript functionality here
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            const cards = document.querySelectorAll('.stat-card, .recent-activity, .quick-actions');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
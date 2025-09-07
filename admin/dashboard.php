<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']['status'])) {
    header("location:login.php");
    exit();
}

include("../includes/connection.php");

// Get statistics
$topicsQuery = "SELECT COUNT(*) as total, 
                SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'taken' THEN 1 ELSE 0 END) as accepted,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as rejected
                FROM topics";
$topicsResult = $link->query($topicsQuery);
$topicsStats = $topicsResult->fetch_assoc();

$usersQuery = "SELECT COUNT(*) as total FROM register";
$usersResult = $link->query($usersQuery);
$usersStats = $usersResult->fetch_assoc();

$contactsQuery = "SELECT COUNT(*) as total FROM contact";
$contactsResult = $link->query($contactsQuery);
$contactsStats = $contactsResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Project Topic Checker</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            color: #2c3e50;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 14px;
            opacity: 0.8;
            margin: 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            gap: 15px;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid #667eea;
        }

        .sidebar-menu a i {
            width: 24px;
            text-align: center;
            font-size: 18px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        .topbar {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h2 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info .avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .user-info .details {
            text-align: right;
        }

        .user-info .name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
        }

        .user-info .role {
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 30px;
        }

        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .welcome-banner h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-banner p {
            font-size: 18px;
            opacity: 0.9;
            margin: 0;
            max-width: 600px;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: white;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, #e74c3c, #e67e22);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .stat-title {
            font-size: 18px;
            font-weight: 600;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-description {
            font-size: 14px;
            color: #95a5a6;
            margin: 0;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h3 {
            font-size: 24px;
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
        }

        .section-header a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-header a:hover {
            color: #764ba2;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            font-size: 15px;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-available {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-taken {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-completed {
            background: #e3f2fd;
            color: #1565c0;
        }

        .action-btn {
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-accept {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .btn-reject {
            background: #ffebee;
            color: #c62828;
        }

        .btn-view {
            background: #e3f2fd;
            color: #1565c0;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            
            .sidebar-header h1, .sidebar-header p, .sidebar-menu span {
                display: none;
            }
            
            .sidebar-menu a {
                justify-content: center;
                padding: 15px;
            }
            
            .sidebar-menu a i {
                margin: 0;
            }
            
            .main-content {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .dashboard-content {
                padding: 20px;
            }
            
            .topbar {
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Admin Panel</h1>
                <p>Project Topic Checker</p>
            </div>
            
            <div class="sidebar-menu">
                <ul>
                    <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                    <li><a href="topics.php"><i class="fas fa-book"></i> <span>Manage Topics</span></a></li>
                    <li><a href="users.php"><i class="fas fa-users"></i> <span>Manage Users</span></a></li>
                    <li><a href="messages.php"><i class="fas fa-envelope"></i> <span>Messages</span></a></li>
                    <li><a href="settings.php"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <h2>Dashboard</h2>
                
                <div class="user-info">
                    <div class="details">
                        <div class="name"><?php echo htmlspecialchars($_SESSION['admin']['username']); ?></div>
                        <div class="role">Administrator</div>
                    </div>
                    <div class="avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <div class="welcome-banner">
                    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['admin']['username']); ?>!</h1>
                    <p>Here's what's happening with your Project Topic Checker system today.</p>
                </div>
                
                <!-- Statistics Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-title">Total Topics</div>
                        <div class="stat-number"><?php echo $topicsStats['total']; ?></div>
                        <p class="stat-description">All project topics in the system</p>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-title">Registered Users</div>
                        <div class="stat-number"><?php echo $usersStats['total']; ?></div>
                        <p class="stat-description">Active user accounts</p>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stat-title">Messages</div>
                        <div class="stat-number"><?php echo $contactsStats['total']; ?></div>
                        <p class="stat-description">Contact form submissions</p>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="stat-title">Pending Topics</div>
                        <div class="stat-number"><?php echo $topicsStats['pending']; ?></div>
                        <p class="stat-description">Topics awaiting approval</p>
                    </div>
                </div>
                
                <!-- Recent Topics -->
                <div class="recent-activity">
                    <div class="section-header">
                        <h3><i class="fas fa-clock"></i> Recent Topics</h3>
                        <a href="topics.php"><i class="fas fa-arrow-right"></i> View All Topics</a>
                    </div>
                    
                    <div class="table-container">
                        <?php
                        $recentTopicsQuery = "SELECT * FROM topics ORDER BY id DESC LIMIT 5";
                        $recentTopicsResult = $link->query($recentTopicsQuery);
                        
                        if ($recentTopicsResult && $recentTopicsResult->num_rows > 0) {
                            echo '<table>';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Topic Title</th>';
                            echo '<th>Status</th>';
                            echo '<th>Created Date</th>';
                            echo '<th>Actions</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            
                            while ($topic = $recentTopicsResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($topic['topic_title']) . '</td>';
                                echo '<td><span class="status-badge status-' . $topic['status'] . '">' . ucfirst($topic['status']) . '</span></td>';
                                echo '<td>' . date('M j, Y', strtotime($topic['created_at'])) . '</td>';
                                echo '<td>';
                                echo '<a href="topics.php?action=view&id=' . $topic['id'] . '" class="action-btn btn-view"><i class="fas fa-eye"></i> View</a> ';
                                echo '<a href="topics.php?action=edit&id=' . $topic['id'] . '" class="action-btn btn-accept"><i class="fas fa-edit"></i> Edit</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<p>No topics found.</p>';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Recent Users -->
                <div class="recent-activity">
                    <div class="section-header">
                        <h3><i class="fas fa-user-clock"></i> Recent Users</h3>
                        <a href="users.php"><i class="fas fa-arrow-right"></i> View All Users</a>
                    </div>
                    
                    <div class="table-container">
                        <?php
                        $recentUsersQuery = "SELECT * FROM register ORDER BY r_id DESC LIMIT 5";
                        $recentUsersResult = $link->query($recentUsersQuery);
                        
                        if ($recentUsersResult && $recentUsersResult->num_rows > 0) {
                            echo '<table>';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Full Name</th>';
                            echo '<th>Username</th>';
                            echo '<th>Email</th>';
                            echo '<th>Joined Date</th>';
                            echo '<th>Actions</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            
                            while ($user = $recentUsersResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($user['r_fnm']) . '</td>';
                                echo '<td>' . htmlspecialchars($user['r_unm']) . '</td>';
                                echo '<td>' . htmlspecialchars($user['r_email']) . '</td>';
                                echo '<td>' . date('M j, Y', $user['r_time']) . '</td>';
                                echo '<td>';
                                echo '<a href="users.php?action=view&id=' . $user['r_id'] . '" class="action-btn btn-view"><i class="fas fa-eye"></i> View</a> ';
                                echo '<a href="users.php?action=delete&id=' . $user['r_id'] . '" class="action-btn btn-reject" onclick="return confirm(\'Are you sure you want to delete this user?\')"><i class="fas fa-trash"></i> Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<p>No users found.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
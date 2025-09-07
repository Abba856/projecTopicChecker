<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']['status'])) {
    header("location:login.php");
    exit();
}

include("../includes/connection.php");

// Get message ID from URL
$message_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($message_id <= 0) {
    header("location:messages.php");
    exit();
}

// Get message details
$stmt = $link->prepare("SELECT * FROM contact WHERE c_id = ?");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("location:messages.php");
    exit();
}

$message = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message - Admin Panel</title>
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

        .sidebar-menu a.active {
            background: rgba(102, 126, 234, 0.2);
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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: #2c3e50;
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .breadcrumb i {
            font-size: 14px;
        }

        .alert {
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            color: #2e7d32;
            border-left: 5px solid #2e7d32;
        }

        .alert-error {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            color: #c62828;
            border-left: 5px solid #c62828;
        }

        .message-details {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
            margin-bottom: 30px;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .message-title {
            flex: 1;
        }

        .message-title h2 {
            color: #2c3e50;
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 15px 0;
            line-height: 1.3;
        }

        .message-meta {
            display: flex;
            gap: 25px;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .meta-value {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }

        .section-title {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin: 30px 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .section-title i {
            color: #667eea;
            margin-right: 10px;
        }

        .message-content {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            font-size: 16px;
            line-height: 1.7;
            color: #2c3e50;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
            white-space: pre-wrap;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            border-left: 4px solid #667eea;
        }

        .info-card h3 {
            color: #2c3e50;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 15px 0;
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #2c3e50;
            word-break: break-word;
        }

        .actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #f0f0f0;
        }

        .action-btn {
            padding: 14px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-delete {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }

        .btn-back {
            background: #f8f9fa;
            color: #2c3e50;
            border: 1px solid #dee2e6;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .action-btn:active {
            transform: translateY(-1px);
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
            
            .message-header {
                flex-direction: column;
                gap: 20px;
            }
            
            .message-meta {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .dashboard-content {
                padding: 20px;
            }
            
            .topbar {
                padding: 15px 20px;
            }
            
            .message-details {
                padding: 25px 20px;
            }
            
            .message-title h2 {
                font-size: 26px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
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
                    <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                    <li><a href="topics.php"><i class="fas fa-book"></i> <span>Manage Topics</span></a></li>
                    <li><a href="users.php"><i class="fas fa-users"></i> <span>Manage Users</span></a></li>
                    <li><a href="messages.php" class="active"><i class="fas fa-envelope"></i> <span>Messages</span></a></li>
                    <li><a href="settings.php"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <h2>View Message</h2>
                
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
                <div class="page-header">
                    <h1><i class="fas fa-envelope"></i> Message Details</h1>
                </div>
                
                <div class="breadcrumb">
                    <a href="dashboard.php">Dashboard</a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="messages.php">Messages</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>View Message</span>
                </div>
                
                <!-- Alert Messages -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Message Details -->
                <div class="message-details">
                    <div class="message-header">
                        <div class="message-title">
                            <h2><?php echo htmlspecialchars($message['c_nm']); ?></h2>
                            <div class="message-meta">
                                <div class="meta-item">
                                    <div class="meta-label">From</div>
                                    <div class="meta-value"><?php echo htmlspecialchars($message['c_email']); ?></div>
                                </div>
                                <div class="meta-item">
                                    <div class="meta-label">Message ID</div>
                                    <div class="meta-value">#<?php echo $message['c_id']; ?></div>
                                </div>
                                <div class="meta-item">
                                    <div class="meta-label">Date</div>
                                    <div class="meta-value"><?php echo date('F j, Y \a\t g:i A', $message['c_time']); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="section-title"><i class="fas fa-phone"></i> Contact Information</h3>
                    <div class="info-grid">
                        <div class="info-card">
                            <h3>Sender Details</h3>
                            <div class="info-item">
                                <div class="info-label">Full Name</div>
                                <div class="info-value"><?php echo htmlspecialchars($message['c_nm']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email Address</div>
                                <div class="info-value"><?php echo htmlspecialchars($message['c_email']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Mobile Number</div>
                                <div class="info-value"><?php echo htmlspecialchars($message['c_mno']); ?></div>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <h3>Message Details</h3>
                            <div class="info-item">
                                <div class="info-label">Received Date</div>
                                <div class="info-value"><?php echo date('F j, Y', $message['c_time']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Received Time</div>
                                <div class="info-value"><?php echo date('g:i A', $message['c_time']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Message ID</div>
                                <div class="info-value">#<?php echo $message['c_id']; ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="section-title"><i class="fas fa-envelope-open-text"></i> Message Content</h3>
                    <div class="message-content">
                        <?php echo htmlspecialchars($message['c_msg']); ?>
                    </div>
                    
                    <div class="actions">
                        <a href="messages.php?action=delete&id=<?php echo $message['c_id']; ?>" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete this message?')">
                            <i class="fas fa-trash"></i> Delete Message
                        </a>
                        <a href="messages.php" class="action-btn btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
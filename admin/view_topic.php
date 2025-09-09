<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']['status'])) {
    header("location:login_new.php");
    exit();
}

include("../includes/connection.php");

// Get topic ID from URL
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($topic_id <= 0) {
    header("location:topics.php");
    exit();
}

// Get topic details
$stmt = $link->prepare("SELECT * FROM topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("location:topics.php");
    exit();
}

$topic = $result->fetch_assoc();

// Handle topic actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'accept') {
        $updateQuery = "UPDATE topics SET status = 'taken' WHERE id = ?";
        $stmt = $link->prepare($updateQuery);
        $stmt->bind_param("i", $topic_id);
        $stmt->execute();
        $_SESSION['message'] = "Topic accepted successfully!";
    } elseif ($action == 'reject') {
        $updateQuery = "UPDATE topics SET status = 'completed' WHERE id = ?";
        $stmt = $link->prepare($updateQuery);
        $stmt->bind_param("i", $topic_id);
        $stmt->execute();
        $_SESSION['message'] = "Topic rejected successfully!";
    } elseif ($action == 'reset') {
        $updateQuery = "UPDATE topics SET status = 'available' WHERE id = ?";
        $stmt = $link->prepare($updateQuery);
        $stmt->bind_param("i", $topic_id);
        $stmt->execute();
        $_SESSION['message'] = "Topic status reset to pending!";
    }
    
    header("location:view_topic.php?id=" . $topic_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Topic - Admin Panel</title>
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

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb i {
            font-size: 0.7rem;
        }

        /* Topic Details */
        .topic-details {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
        }

        .topic-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .topic-title h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gray-800);
            margin: 0 0 15px 0;
        }

        .topic-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-bottom: 5px;
        }

        .meta-value {
            font-weight: 600;
            color: var(--gray-800);
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-available {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .status-taken {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .status-completed {
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 30px 0 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .abstract-content {
            background: var(--gray-100);
            border-radius: 8px;
            padding: 20px;
            white-space: pre-wrap;
            line-height: 1.8;
            color: var(--gray-800);
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-accept {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-accept:hover {
            background: rgba(16, 185, 129, 0.2);
        }

        .btn-reject {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .btn-reset {
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .btn-reset:hover {
            background: rgba(59, 130, 246, 0.2);
        }

        .btn-back {
            background: var(--gray-200);
            color: var(--gray-800);
            border: 1px solid var(--gray-300);
        }

        .btn-back:hover {
            background: var(--gray-300);
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

        /* Responsive Design */
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .dashboard-content {
                padding: 20px;
            }
            
            .admin-header {
                padding: 0 20px;
            }
            
            .topic-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .topic-details {
                padding: 20px;
            }
            
            .topic-meta {
                flex-direction: column;
                gap: 15px;
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
            <a href="topics.php" class="menu-item active">
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
                <h1>View Topic</h1>
                <p>Review project topic details</p>
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
            <div class="breadcrumb">
                <a href="dashboard_modern.php">Dashboard</a>
                <i class="fas fa-chevron-right"></i>
                <a href="topics.php">Topics</a>
                <i class="fas fa-chevron-right"></i>
                <span>View Topic</span>
            </div>
            
            <!-- Alert Messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Topic Details -->
            <div class="topic-details">
                <div class="topic-header">
                    <div class="topic-title">
                        <h2><?php echo htmlspecialchars($topic['topic_title']); ?></h2>
                        <div class="topic-meta">
                            <div class="meta-item">
                                <div class="meta-label">Created Date</div>
                                <div class="meta-value"><?php echo date('F j, Y', strtotime($topic['created_at'])); ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Topic ID</div>
                                <div class="meta-value">#<?php echo $topic['id']; ?></div>
                            </div>
                        </div>
                    </div>
                    <span class="status-badge status-<?php echo $topic['status']; ?>">
                        <?php echo ucfirst($topic['status']); ?>
                    </span>
                </div>
                
                <h3 class="section-title"><i class="fas fa-file-alt"></i> Project Abstract</h3>
                <div class="abstract-content">
                    <?php echo nl2br(htmlspecialchars($topic['project_abstract'])); ?>
                </div>
                
                <h3 class="section-title"><i class="fas fa-align-left"></i> Topic Description</h3>
                <div class="abstract-content">
                    <?php echo nl2br(htmlspecialchars($topic['topic_text'])); ?>
                </div>
                
                <div class="actions">
                    <?php if ($topic['status'] == 'available'): ?>
                        <a href="?id=<?php echo $topic['id']; ?>&action=accept" class="action-btn btn-accept" onclick="return confirm('Are you sure you want to accept this topic?')">
                            <i class="fas fa-check"></i> Accept Topic
                        </a>
                        <a href="?id=<?php echo $topic['id']; ?>&action=reject" class="action-btn btn-reject" onclick="return confirm('Are you sure you want to reject this topic?')">
                            <i class="fas fa-times"></i> Reject Topic
                        </a>
                    <?php elseif ($topic['status'] == 'taken'): ?>
                        <a href="?id=<?php echo $topic['id']; ?>&action=reset" class="action-btn btn-reset" onclick="return confirm('Are you sure you want to reset this topic to pending?')">
                            <i class="fas fa-undo"></i> Reset to Pending
                        </a>
                        <a href="?id=<?php echo $topic['id']; ?>&action=reject" class="action-btn btn-reject" onclick="return confirm('Are you sure you want to reject this topic?')">
                            <i class="fas fa-times"></i> Reject Topic
                        </a>
                    <?php elseif ($topic['status'] == 'completed'): ?>
                        <a href="?id=<?php echo $topic['id']; ?>&action=reset" class="action-btn btn-reset" onclick="return confirm('Are you sure you want to reset this topic to pending?')">
                            <i class="fas fa-undo"></i> Reset to Pending
                        </a>
                        <a href="?id=<?php echo $topic['id']; ?>&action=accept" class="action-btn btn-accept" onclick="return confirm('Are you sure you want to accept this topic?')">
                            <i class="fas fa-check"></i> Accept Topic
                        </a>
                    <?php endif; ?>
                    
                    <a href="topics.php" class="action-btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Topics
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
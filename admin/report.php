<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']['status'])) {
    header("location:login_new.php");
    exit();
}

include("../includes/connection.php");

// Handle CSV download
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    // Get filter parameters
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
    
    // Build query based on filters
    $whereClause = "";
    $params = array();
    $types = "";
    
    if ($statusFilter != 'all') {
        $whereClause .= "WHERE status = ? ";
        $params[] = $statusFilter;
        $types .= "s";
    }
    
    if (!empty($startDate)) {
        $whereClause .= ($whereClause ? "AND " : "WHERE ") . "DATE(created_at) >= ? ";
        $params[] = $startDate;
        $types .= "s";
    }
    
    if (!empty($endDate)) {
        $whereClause .= ($whereClause ? "AND " : "WHERE ") . "DATE(created_at) <= ? ";
        $params[] = $endDate;
        $types .= "s";
    }
    
    // Get topics data
    $query = "SELECT * FROM topics " . $whereClause . "ORDER BY created_at DESC";
    $stmt = $link->prepare($query);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Create CSV content for download
    $csvContent = "Project Topic Report\n";
    $csvContent .= "Generated on: " . date('Y-m-d H:i:s') . "\n\n";
    
    // Add filter information
    $statusText = 'All Statuses';
    if ($statusFilter == 'available') $statusText = 'Pending';
    if ($statusFilter == 'taken') $statusText = 'Accepted';
    if ($statusFilter == 'completed') $statusText = 'Rejected';
    
    $csvContent .= "Filters Applied:\n";
    $csvContent .= "Status: " . $statusText . "\n";
    $csvContent .= "Date Range: " . ($startDate ? $startDate : 'Any') . " to " . ($endDate ? $endDate : 'Any') . "\n\n";
    
    // Add header row
    $csvContent .= "ID,Topic Title,Status,Created Date\n";
    
    // Add data rows
    while ($topic = $result->fetch_assoc()) {
        $statusText = ucfirst($topic['status']);
        if ($topic['status'] == 'available') $statusText = 'Pending';
        if ($topic['status'] == 'taken') $statusText = 'Accepted';
        if ($topic['status'] == 'completed') $statusText = 'Rejected';
        
        $csvContent .= "\"" . $topic['id'] . "\",";
        $csvContent .= "\"" . str_replace('"', '""', $topic['topic_title']) . "\",";
        $csvContent .= "\"" . $statusText . "\",";
        $csvContent .= "\"" . date('M j, Y', strtotime($topic['created_at'])) . "\"\n";
    }
    
    // Set headers for download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="project_topics_report_' . date('Y-m-d') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    echo $csvContent;
    exit();
}

// Get filter parameters for display
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Build query based on filters
$whereClause = "";
$params = array();
$types = "";

if ($statusFilter != 'all') {
    $whereClause .= "WHERE status = ? ";
    $params[] = $statusFilter;
    $types .= "s";
}

if (!empty($startDate)) {
    $whereClause .= ($whereClause ? "AND " : "WHERE ") . "DATE(created_at) >= ? ";
    $params[] = $startDate;
    $types .= "s";
}

if (!empty($endDate)) {
    $whereClause .= ($whereClause ? "AND " : "WHERE ") . "DATE(created_at) <= ? ";
    $params[] = $endDate;
    $types .= "s";
}

// Get topics data
$query = "SELECT * FROM topics " . $whereClause . "ORDER BY created_at DESC";
$stmt = $link->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Get statistics - use the same where clause as main query
$statsQuery = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'taken' THEN 1 ELSE 0 END) as accepted,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as rejected
    FROM topics " . $whereClause;
    
$statsStmt = $link->prepare($statsQuery);

if (!empty($params)) {
    $statsStmt->bind_param($types, ...$params);
}

$statsStmt->execute();
$statsResult = $statsStmt->get_result();
$stats = $statsResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Admin Panel</title>
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

        /* Filter Section */
        .filters-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            margin-bottom: 30px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: end;
        }

        .form-group {
            min-width: 200px;
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
            padding: 12px 20px;
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

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-800);
        }

        .btn-secondary:hover {
            background: var(--gray-300);
        }

        .btn-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            background: rgba(16, 185, 129, 0.2);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
            color: var(--gray-800);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-800);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: var(--gray-100);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--gray-300);
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--gray-800);
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

        /* Scrollable Table Container */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -25px;
            padding: 0 25px;
        }
        
        .table-responsive table {
            min-width: 600px;
            width: 100%;
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
            
            .filter-row {
                grid-template-columns: 1fr;
            }
            
            .filter-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .form-group label {
                font-size: 0.9rem;
            }
            
            .form-control {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-title {
                font-size: 0.9rem;
            }
            
            .stat-value {
                font-size: 1.6rem;
            }
            
            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
                margin: 0 auto 15px;
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
            .table-container {
                padding: 15px;
            }
            
            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            th, td {
                padding: 12px 10px;
                font-size: 0.9rem;
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
            <a href="report.php" class="menu-item active">
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
                <h1>Reports</h1>
                <p>Download reports</p>
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
            <div class="page-header">
                <h1 class="page-title">Project Topics Report</h1>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <form method="GET" action="">
                    <div class="filter-row">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="all" <?php echo ($statusFilter == 'all') ? 'selected' : ''; ?>>All Statuses</option>
                                <option value="available" <?php echo ($statusFilter == 'available') ? 'selected' : ''; ?>>Pending</option>
                                <option value="taken" <?php echo ($statusFilter == 'taken') ? 'selected' : ''; ?>>Accepted</option>
                                <option value="completed" <?php echo ($statusFilter == 'completed') ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($startDate); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($endDate); ?>">
                        </div>
                    </div>
                    
                    <div class="filter-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                        <a href="report.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                        <button type="submit" name="download" value="csv" class="btn btn-success">
                            <i class="fas fa-download"></i> Download CSV Report
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-title">Total Topics</div>
                    <div class="stat-value"><?php echo $stats['total'] ?? 0; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-title">Pending</div>
                    <div class="stat-value"><?php echo $stats['pending'] ?? 0; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-title">Accepted</div>
                    <div class="stat-value"><?php echo $stats['accepted'] ?? 0; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-title">Rejected</div>
                    <div class="stat-value"><?php echo $stats['rejected'] ?? 0; ?></div>
                </div>
            </div>

            <!-- Topics Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3>Filtered Topics</h3>
                    <div>Showing <?php echo $result->num_rows; ?> topics</div>
                </div>
                
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Topic Title</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($topic = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $topic['id']; ?></td>
                                        <td><?php echo htmlspecialchars(substr($topic['topic_title'], 0, 50)) . (strlen($topic['topic_title']) > 50 ? '...' : ''); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $topic['status']; ?>">
                                                <?php 
                                                switch($topic['status']) {
                                                    case 'available': echo 'Pending'; break;
                                                    case 'taken': echo 'Accepted'; break;
                                                    case 'completed': echo 'Rejected'; break;
                                                    default: echo ucfirst($topic['status']);
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M j, Y', strtotime($topic['created_at'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <h3>No Topics Found</h3>
                        <p>There are no topics matching your current filter criteria.</p>
                    </div>
                <?php endif; ?>
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
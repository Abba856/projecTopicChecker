<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']['status'])) {
    header("location:login_new.php");
    exit();
}

include("../includes/connection.php");

// Handle user deletion
if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'delete') {
    $user_id = intval($_GET['id']);
    
    // Prevent deletion of the admin user
    $stmt = $link->prepare("SELECT r_unm FROM register WHERE r_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['r_unm'] !== $_SESSION['admin']['unm']) {
            $stmt = $link->prepare("DELETE FROM register WHERE r_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $_SESSION['message'] = "User deleted successfully!";
        } else {
            $_SESSION['error'] = "You cannot delete your own account!";
        }
    } else {
        $_SESSION['error'] = "User not found!";
    }
    
    header("location:users.php");
    exit();
}

// Get search parameter
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Build query based on search
$whereClause = "";
$params = array();
$types = "";

if (!empty($searchTerm)) {
    $whereClause = "WHERE r_fnm LIKE ? OR r_unm LIKE ? OR r_email LIKE ?";
    $searchParam = "%" . $searchTerm . "%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types = "sss";
}

// Count total records for pagination
$countQuery = "SELECT COUNT(*) as total FROM register " . $whereClause;
$stmt = $link->prepare($countQuery);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$countResult = $stmt->get_result();
$totalRecords = $countResult->fetch_assoc()['total'];

// Pagination
$recordsPerPage = 10;
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $recordsPerPage;

// Get users with pagination
$query = "SELECT * FROM register " . $whereClause . " ORDER BY r_id DESC LIMIT ? OFFSET ?";

// Prepare parameters array for query (including pagination)
$queryParams = $params;
$queryParams[] = $recordsPerPage;
$queryParams[] = $offset;
$queryTypes = $types . "ii";

$stmt = $link->prepare($query);
$stmt->bind_param($queryTypes, ...$queryParams);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
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

        /* Filter and Search */
        .filters-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            margin-bottom: 30px;
        }

        .filter-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            align-items: end;
        }

        .form-group {
            flex: 1;
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

        .user-avatar-table {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .view-btn {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
        }

        .view-btn:hover {
            background: rgba(102, 126, 234, 0.2);
        }

        .delete-btn {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .delete-btn:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .pagination a, .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination a {
            background: white;
            color: var(--gray-800);
            border: 1px solid var(--gray-300);
        }

        .pagination a:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }

        .pagination .current {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
        }

        .pagination .disabled {
            background: var(--gray-100);
            color: var(--gray-400);
            border: 1px solid var(--gray-200);
            cursor: not-allowed;
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
            
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .form-group {
                min-width: auto;
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
            
            th, td {
                padding: 12px 10px;
                font-size: 0.9rem;
            }
            
            .actions {
                flex-direction: column;
                gap: 5px;
            }
            
            .action-btn {
                width: 30px;
                height: 30px;
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
            .table-container {
                padding: 15px;
            }
            
            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
            <a href="users.php" class="menu-item active">
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
                <h1>Manage Users</h1>
                <p>manage registered users</p>
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
                <h1 class="page-title">Registered Users</h1>
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

            <!-- Filters Section -->
            <div class="filters-section">
                <form method="GET" action="">
                    <div class="filter-row">
                        <div class="form-group">
                            <label for="search">Search Users</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search by name, username, or email..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <?php if (!empty($searchTerm)): ?>
                                <a href="users.php" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3>All Users</h3>
                    <div>Showing <?php echo $result->num_rows; ?> of <?php echo $totalRecords; ?> users</div>
                </div>
                
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <div class="user-avatar-table">
                                                    <?php echo strtoupper(substr($user['r_fnm'], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($user['r_fnm']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($user['r_unm']); ?></td>
                                        <td><?php echo htmlspecialchars($user['r_email']); ?></td>
                                        <td><?php echo date('M j, Y', $user['r_time']); ?></td>
                                        <td class="actions">
                                            <a href="view_user.php?id=<?php echo $user['r_id']; ?>" class="action-btn view-btn" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($user['r_unm'] !== $_SESSION['admin']['unm']): ?>
                                                <a href="?action=delete&id=<?php echo $user['r_id']; ?>" class="action-btn delete-btn" title="Delete User" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <div class="pagination">
                            <?php if ($currentPage > 1): ?>
                                <a href="?page=1<?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                    <i class="fas fa-angle-double-left"></i> First
                                </a>
                                <a href="?page=<?php echo $currentPage - 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                    <i class="fas fa-angle-left"></i> Previous
                                </a>
                            <?php else: ?>
                                <span class="disabled"><i class="fas fa-angle-double-left"></i> First</span>
                                <span class="disabled"><i class="fas fa-angle-left"></i> Previous</span>
                            <?php endif; ?>
                            
                            <?php
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);
                            
                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <?php if ($i == $currentPage): ?>
                                    <span class="current"><?php echo $i; ?></span>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <a href="?page=<?php echo $currentPage + 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                    Next <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="?page=<?php echo $totalPages; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                    Last <i class="fas fa-angle-double-right"></i>
                                </a>
                            <?php else: ?>
                                <span class="disabled">Next <i class="fas fa-angle-right"></i></span>
                                <span class="disabled">Last <i class="fas fa-angle-double-right"></i></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h3>No Users Found</h3>
                        <p>There are no users matching your current criteria.</p>
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

<?php
session_start();
include("includes/connection.php");

// Check if user is admin
if(! isset($_SESSION['admin']['status'])) {
    header("location:login.php");
    exit();
}

// Get counts for dashboard statistics
$book_count = 0;
$category_count = 0;
$user_count = 0;
$contact_count = 0;

// Get book count
$book_q = "SELECT COUNT(*) as count FROM book";
$book_res = $link->query($book_q);
if ($book_res) {
    $book_row = $book_res->fetch_assoc();
    $book_count = $book_row['count'];
}

// Get category count
$category_q = "SELECT COUNT(*) as count FROM category";
$category_res = $link->query($category_q);
if ($category_res) {
    $category_row = $category_res->fetch_assoc();
    $category_count = $category_row['count'];
}

// Get user count
$user_q = "SELECT COUNT(*) as count FROM users";
$user_res = $link->query($user_q);
if ($user_res) {
    $user_row = $user_res->fetch_assoc();
    $user_count = $user_row['count'];
}

// Get contact count
$contact_q = "SELECT COUNT(*) as count FROM contact";
$contact_res = $link->query($contact_q);
if ($contact_res) {
    $contact_row = $contact_res->fetch_assoc();
    $contact_count = $contact_row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookWorm</title>
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
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #2c3e50 0%, #1a2530 100%);
            color: white;
            box-shadow: 3px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.2);
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            color: #bdc3c7;
            margin: 5px 0 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .menu-link:hover, .menu-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid #3498db;
        }

        .menu-link i {
            width: 25px;
            font-size: 1.1rem;
            margin-right: 15px;
        }

        .submenu {
            padding-left: 50px;
            display: none;
        }

        .submenu.active {
            display: block;
        }

        .submenu .menu-link {
            padding: 8px 20px;
            font-size: 0.9rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            transition: all 0.3s ease;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-left h1 {
            font-size: 1.5rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            color: #7f8c8d;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .welcome-banner h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .welcome-banner p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            text-align: center;
            border-top: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .stat-card.books { border-top-color: #3498db; }
        .stat-card.categories { border-top-color: #2ecc71; }
        .stat-card.users { border-top-color: #f39c12; }
        .stat-card.messages { border-top-color: #e74c3c; }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-card.books .stat-icon { color: #3498db; }
        .stat-card.categories .stat-icon { color: #2ecc71; }
        .stat-card.users .stat-icon { color: #f39c12; }
        .stat-card.messages .stat-icon { color: #e74c3c; }

        .stat-title {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card.books .stat-value { color: #3498db; }
        .stat-card.categories .stat-value { color: #2ecc71; }
        .stat-card.users .stat-value { color: #f39c12; }
        .stat-card.messages .stat-value { color: #e74c3c; }

        /* Recent Activity */
        .recent-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .activity-card, .quick-actions-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .card-header h3 {
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .view-all {
            color: #3498db;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #f5f5f5;
            display: flex;
            align-items: flex-start;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .activity-icon.book { background: #e3f2fd; color: #3498db; }
        .activity-icon.category { background: #e8f5e9; color: #2ecc71; }
        .activity-icon.user { background: #fff8e1; color: #f39c12; }
        .activity-icon.message { background: #ffebee; color: #e74c3c; }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        /* Quick Actions */
        .action-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            color: white;
            font-weight: 500;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .action-btn i {
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .action-btn.book { background: linear-gradient(135deg, #3498db, #2980b9); }
        .action-btn.category { background: linear-gradient(135deg, #2ecc71, #27ae60); }
        .action-btn.user { background: linear-gradient(135deg, #f39c12, #d35400); }
        .action-btn.message { background: linear-gradient(135deg, #e74c3c, #c0392b); }

        /* Responsive Design */
        @media (max-width: 992px) {
            .recent-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-header h3, .sidebar-header p, .menu-link span {
                display: none;
            }
            
            .menu-link {
                justify-content: center;
                padding: 15px;
            }
            
            .menu-link i {
                margin-right: 0;
                font-size: 1.3rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .topbar {
                padding: 15px;
            }
            
            .user-info {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 20px 15px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>BookWorm Admin</h3>
            <p>Content Management</p>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-item">
                <a href="index.php" class="menu-link active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="#" class="menu-link" onclick="toggleSubmenu('category-submenu')">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                    <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
                </a>
                <div class="submenu" id="category-submenu">
                    <a href="category_add.php" class="menu-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Category</span>
                    </a>
                    <a href="category_view.php" class="menu-link">
                        <i class="fas fa-list"></i>
                        <span>View Categories</span>
                    </a>
                </div>
            </div>
            
            <div class="menu-item">
                <a href="#" class="menu-link" onclick="toggleSubmenu('book-submenu')">
                    <i class="fas fa-book"></i>
                    <span>Books</span>
                    <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
                </a>
                <div class="submenu" id="book-submenu">
                    <a href="book_add.php" class="menu-link">
                        <i class="fas fa-plus"></i>
                        <span>Add Book</span>
                    </a>
                    <a href="book_view.php" class="menu-link">
                        <i class="fas fa-list"></i>
                        <span>View Books</span>
                    </a>
                </div>
            </div>
            
            <div class="menu-item">
                <a href="contact_view.php" class="menu-link">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="Users_view.php" class="menu-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="logout.php" class="menu-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <h1>Dashboard</h1>
            </div>
            
            <div class="topbar-right">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                
                <div class="user-profile">
                    <div class="user-avatar">
                        <?php echo substr($_SESSION['admin']['unm'], 0, 1); ?>
                    </div>
                    <div class="user-info">
                        <div class="user-name"><?php echo $_SESSION['admin']['unm']; ?></div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <h2>Welcome back, <?php echo $_SESSION['admin']['unm']; ?>!</h2>
                <p>Here's what's happening with your BookWorm system today. Manage your books, categories, and users all in one place.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card books">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-title">Total Books</div>
                    <div class="stat-value"><?php echo $book_count; ?></div>
                </div>
                
                <div class="stat-card categories">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-title">Categories</div>
                    <div class="stat-value"><?php echo $category_count; ?></div>
                </div>
                
                <div class="stat-card users">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-title">Registered Users</div>
                    <div class="stat-value"><?php echo $user_count; ?></div>
                </div>
                
                <div class="stat-card messages">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-title">Messages</div>
                    <div class="stat-value"><?php echo $contact_count; ?></div>
                </div>
            </div>

            <!-- Recent Activity and Quick Actions -->
            <div class="recent-section">
                <div class="activity-card">
                    <div class="card-header">
                        <h3>Recent Activity</h3>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-icon book">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">New book added: "The Great Adventure"</div>
                                <div class="activity-time">2 hours ago</div>
                            </div>
                        </li>
                        
                        <li class="activity-item">
                            <div class="activity-icon category">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Category "Mystery" created</div>
                                <div class="activity-time">5 hours ago</div>
                            </div>
                        </li>
                        
                        <li class="activity-item">
                            <div class="activity-icon user">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">New user registered: john_doe</div>
                                <div class="activity-time">1 day ago</div>
                            </div>
                        </li>
                        
                        <li class="activity-item">
                            <div class="activity-icon message">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">New contact message received</div>
                                <div class="activity-time">2 days ago</div>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="quick-actions-card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>
                    
                    <div class="action-grid">
                        <a href="book_add.php" class="action-btn book">
                            <i class="fas fa-plus-circle"></i>
                            Add New Book
                        </a>
                        
                        <a href="category_add.php" class="action-btn category">
                            <i class="fas fa-tags"></i>
                            Add Category
                        </a>
                        
                        <a href="book_view.php" class="action-btn book">
                            <i class="fas fa-book-open"></i>
                            View All Books
                        </a>
                        
                        <a href="contact_view.php" class="action-btn message">
                            <i class="fas fa-envelope"></i>
                            View Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSubmenu(id) {
            const submenu = document.getElementById(id);
            submenu.classList.toggle('active');
        }
        
        // Set active menu item based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const menuLinks = document.querySelectorAll('.menu-link');
            
            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
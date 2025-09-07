<?php
include("includes/header.php");
include("../includes/connection.php");

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

<style>
.dashboard-card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 20px;
    border: none;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}

.card-icon {
    font-size: 2.5rem;
    padding: 15px;
    border-radius: 50%;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 15px auto;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-top: 10px;
    margin-bottom: 5px;
}

.card-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.recent-activity {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.activity-item {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.activity-item:last-child {
    border-bottom: none;
}

.quick-actions {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 20px;
}

.action-btn {
    display: block;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    text-align: center;
    color: #fff;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    color: #fff;
    text-decoration: none;
}

.bg-primary-light { background-color: #dbeafe; color: #1d4ed8; }
.bg-success-light { background-color: #dcfce7; color: #166534; }
.bg-warning-light { background-color: #fef3c7; color: #854d0e; }
.bg-danger-light { background-color: #fee2e2; color: #991b1b; }

.welcome-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="welcome-banner">
                <h1>Welcome back, <?php echo $_SESSION['admin']['unm']; ?>!</h1>
                <p class="lead">Here's what's happening with your Online Book Recommendation System today.</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel dashboard-card">
                <div class="panel-body text-center bg-primary-light">
                    <div class="card-icon bg-primary">
                        <i class="fa fa-book fa-fw"></i>
                    </div>
                    <div class="card-title">Total Books</div>
                    <div class="card-value"><?php echo $book_count; ?></div>
                </div>
                <a href="book_view.php">
                    <div class="panel-footer text-center">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel dashboard-card">
                <div class="panel-body text-center bg-success-light">
                    <div class="card-icon bg-success">
                        <i class="fa fa-tags fa-fw"></i>
                    </div>
                    <div class="card-title">Categories</div>
                    <div class="card-value"><?php echo $category_count; ?></div>
                </div>
                <a href="category_view.php">
                    <div class="panel-footer text-center">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel dashboard-card">
                <div class="panel-body text-center bg-warning-light">
                    <div class="card-icon bg-warning">
                        <i class="fa fa-users fa-fw"></i>
                    </div>
                    <div class="card-title">Users</div>
                    <div class="card-value"><?php echo $user_count; ?></div>
                </div>
                <a href="Users_view.php">
                    <div class="panel-footer text-center">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel dashboard-card">
                <div class="panel-body text-center bg-danger-light">
                    <div class="card-icon bg-danger">
                        <i class="fa fa-envelope fa-fw"></i>
                    </div>
                    <div class="card-title">Messages</div>
                    <div class="card-value"><?php echo $contact_count; ?></div>
                </div>
                <a href="contact_view.php">
                    <div class="panel-footer text-center">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Actions -->
    <div class="row">
        <div class="col-lg-8">
            <div class="recent-activity">
                <h3><i class="fa fa-clock-o fa-fw"></i> Recent Activity</h3>
                <div class="activity-item">
                    <strong>Book Management</strong>
                    <p class="text-muted">Manage your book collection, add new books, and update existing ones.</p>
                </div>
                <div class="activity-item">
                    <strong>Category Management</strong>
                    <p class="text-muted">Organize books into categories for better navigation.</p>
                </div>
                <div class="activity-item">
                    <strong>User Management</strong>
                    <p class="text-muted">View and manage registered users of your system.</p>
                </div>
                <div class="activity-item">
                    <strong>Contact Messages</strong>
                    <p class="text-muted">Review messages from users and respond to inquiries.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="quick-actions">
                <h3><i class="fa fa-bolt fa-fw"></i> Quick Actions</h3>
                <a href="book_add.php" class="action-btn bg-primary" style="background-color: #3b82f6;">
                    <i class="fa fa-plus-circle fa-fw"></i> Add New Book
                </a>
                <a href="category_add.php" class="action-btn bg-success" style="background-color: #10b981;">
                    <i class="fa fa-tags fa-fw"></i> Add New Category
                </a>
                <a href="book_view.php" class="action-btn bg-warning" style="background-color: #f59e0b;">
                    <i class="fa fa-book fa-fw"></i> View All Books
                </a>
                <a href="contact_view.php" class="action-btn bg-danger" style="background-color: #ef4444;">
                    <i class="fa fa-envelope fa-fw"></i> View Messages
                </a>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel dashboard-card">
                <div class="panel-heading">
                    <h4><i class="fa fa-info-circle fa-fw"></i> System Information</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Admin Panel</h5>
                            <p>Online Book Recommendation System Admin Dashboard</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Server Time</h5>
                            <p><?php echo date('l, F j, Y \a\t g:i A'); ?></p>
                        </div>
                        <div class="col-md-4">
                            <h5>Quick Support</h5>
                            <p>Need help? Contact system administrator.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<?php
include("includes/footer.php");
?>
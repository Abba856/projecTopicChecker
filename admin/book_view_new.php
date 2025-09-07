<?php
session_start();
include("includes/header.php");
include("../includes/connection.php");

// Check if user is admin
if(! isset($_SESSION['admin']['status'])) {
    header("location:login.php");
    exit();
}

// Get books with categories
$book_q = "SELECT * FROM book INNER JOIN category ON b_cat = cat_id ORDER BY b_time DESC";
$book_res = $link->query($book_q);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management - BookWorm Admin</title>
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

        /* Header Styles */
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: #3498db;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Main Content */
        .content {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 2rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-header {
            padding: 20px 30px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 30px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8f9fa;
        }

        .book-image-cell {
            width: 100px;
        }

        .book-image {
            width: 80px;
            height: 100px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .category-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #e3f2fd;
            color: #1976d2;
        }

        .price {
            font-weight: 700;
            color: #27ae60;
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

        .edit-btn {
            background: #e3f2fd;
            color: #1976d2;
        }

        .edit-btn:hover {
            background: #bbdefb;
        }

        .delete-btn {
            background: #ffebee;
            color: #c62828;
        }

        .delete-btn:hover {
            background: #ffcdd2;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content {
                padding: 20px 15px;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            th, td {
                padding: 12px 15px;
                font-size: 0.9rem;
            }
            
            .book-image {
                width: 60px;
                height: 80px;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            th, td {
                padding: 10px 8px;
                font-size: 0.8rem;
            }
            
            .actions {
                flex-direction: column;
                gap: 5px;
            }
            
            .action-btn {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <h1><i class="fas fa-book"></i> Book Management</h1>
            <div class="breadcrumb">
                <a href="dashboard.php">Dashboard</a>
                <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                <span>Books</span>
            </div>
        </div>
        
        <div class="topbar-right">
            <div class="user-info">
                Admin: <?php echo $_SESSION['admin']['unm']; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <h2 class="page-title">Book List</h2>
            <a href="book_add.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Book
            </a>
        </div>

        <!-- Books Table -->
        <div class="table-container">
            <div class="table-header">
                <h3>All Books</h3>
                <div class="table-actions">
                    <span><?php echo $book_res->num_rows; ?> books</span>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Book Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    while ($book_row = $book_res->fetch_assoc()) {
                        echo '<tr>
                                <td>' . $count . '</td>
                                <td>' . $book_row['b_nm'] . '</td>
                                <td><span class="category-badge">' . $book_row['cat_nm'] . '</span></td>
                                <td class="price">$' . $book_row['b_price'] . '</td>
                                <td class="book-image-cell">
                                    <div class="book-image">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </td>
                                <td>' . date("M d, Y", $book_row['b_time']) . '</td>
                                <td class="actions">
                                    <a href="book_edit.php?id=' . $book_row['b_id'] . '" class="action-btn edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="process_book_del.php?id=' . $book_row['b_id'] . '" class="action-btn delete-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this book?\')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                              </tr>';
                        $count++;
                    }
                    
                    if ($count == 1) {
                        echo '<tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-book" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                                    <h3>No books found</h3>
                                    <p style="color: #7f8c8d;">Add your first book to get started</p>
                                </td>
                              </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
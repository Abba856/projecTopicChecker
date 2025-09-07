<?php
session_start();
include("includes/header.php");
include("../includes/connection.php");

// Check if user is admin
if(! isset($_SESSION['admin']['status'])) {
    header("location:login.php");
    exit();
}

// Get contact messages
$contact_q = "SELECT * FROM contact ORDER BY con_dt DESC";
$contact_res = $link->query($contact_q);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - BookWorm Admin</title>
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

        .message-preview {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-new {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-read {
            background: #e8f5e9;
            color: #2e7d32;
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
            background: #e3f2fd;
            color: #1976d2;
        }

        .view-btn:hover {
            background: #bbdefb;
        }

        .delete-btn {
            background: #ffebee;
            color: #c62828;
        }

        .delete-btn:hover {
            background: #ffcdd2;
        }

        /* Message Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .modal-header {
            padding: 20px 30px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #7f8c8d;
        }

        .modal-body {
            padding: 30px;
        }

        .message-detail {
            margin-bottom: 20px;
        }

        .message-detail label {
            font-weight: 600;
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }

        .message-detail p {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 0;
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
            
            .message-preview {
                max-width: 100px;
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
            <h1><i class="fas fa-envelope"></i> Contact Messages</h1>
            <div class="breadcrumb">
                <a href="dashboard.php">Dashboard</a>
                <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                <span>Messages</span>
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
            <h2 class="page-title">Contact Messages</h2>
        </div>

        <!-- Messages Table -->
        <div class="table-container">
            <div class="table-header">
                <h3>All Messages</h3>
                <div class="table-actions">
                    <span><?php echo $contact_res->num_rows; ?> messages</span>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    while ($contact_row = $contact_res->fetch_assoc()) {
                        $messagePreview = strlen($contact_row['con_msg']) > 50 ? 
                            substr($contact_row['con_msg'], 0, 50) . '...' : 
                            $contact_row['con_msg'];
                        
                        echo '<tr>
                                <td>' . $count . '</td>
                                <td>' . $contact_row['con_nm'] . '</td>
                                <td>' . $contact_row['con_email'] . '</td>
                                <td>' . $contact_row['con_sub'] . '</td>
                                <td class="message-preview">' . $messagePreview . '</td>
                                <td>' . date("M d, Y", strtotime($contact_row['con_dt'])) . '</td>
                                <td><span class="message-status status-new">New</span></td>
                                <td class="actions">
                                    <button class="action-btn view-btn" title="View" onclick="showMessage(\'' . addslashes($contact_row['con_nm']) . '\', \'' . addslashes($contact_row['con_email']) . '\', \'' . addslashes($contact_row['con_sub']) . '\', \'' . addslashes($contact_row['con_msg']) . '\', \'' . date("M d, Y", strtotime($contact_row['con_dt'])) . '\')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="process_contact_del.php?id=' . $contact_row['con_id'] . '" class="action-btn delete-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this message?\')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                              </tr>';
                        $count++;
                    }
                    
                    if ($count == 1) {
                        echo '<tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-envelope" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                                    <h3>No messages found</h3>
                                    <p style="color: #7f8c8d;">No contact messages received yet</p>
                                </td>
                              </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Message Modal -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Message Details</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="message-detail">
                    <label>From:</label>
                    <p id="messageName"></p>
                </div>
                <div class="message-detail">
                    <label>Email:</label>
                    <p id="messageEmail"></p>
                </div>
                <div class="message-detail">
                    <label>Subject:</label>
                    <p id="messageSubject"></p>
                </div>
                <div class="message-detail">
                    <label>Date:</label>
                    <p id="messageDate"></p>
                </div>
                <div class="message-detail">
                    <label>Message:</label>
                    <p id="messageContent" style="white-space: pre-wrap;"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showMessage(name, email, subject, content, date) {
            document.getElementById('messageName').textContent = name;
            document.getElementById('messageEmail').textContent = email;
            document.getElementById('messageSubject').textContent = subject;
            document.getElementById('messageContent').textContent = content;
            document.getElementById('messageDate').textContent = date;
            document.getElementById('messageModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('messageModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('messageModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
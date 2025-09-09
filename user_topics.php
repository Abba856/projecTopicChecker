<?php
// We include the header which starts the session, so we don't need to start it again
include("includes/connection.php");
include("includes/header.php");

// Check if user is logged in (after including header to ensure session is started)
if (!isset($_SESSION['client']['status'])) {
    header("location:login.php");
    exit();
}

// Get filter parameters
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'available';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Build query based on filters
$user_id = $_SESSION['client']['id']; // Get user ID from session
$whereClause = "WHERE user_id = ? AND status = ?";
$params = array($user_id, $statusFilter);
$types = "is";

if (!empty($searchTerm)) {
    $whereClause .= " AND (topic_title LIKE ? OR project_abstract LIKE ?)";
    $params[] = "%" . $searchTerm . "%";
    $params[] = "%" . $searchTerm . "%";
    $types .= "ss";
}

// Count total records for pagination
$countQuery = "SELECT COUNT(*) as total FROM topics " . $whereClause;
$stmt = $link->prepare($countQuery);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$countResult = $stmt->get_result();
$totalRecords = $countResult->fetch_assoc()['total'];

// Pagination
$recordsPerPage = 10;
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $recordsPerPage;

// Get topics with pagination
$query = "SELECT * FROM topics " . $whereClause . " ORDER BY id DESC LIMIT ? OFFSET ?";
$params[] = $recordsPerPage;
$params[] = $offset;
$types .= "ii";

$stmt = $link->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
/* Enhanced Modern Topics Styles */
.modern-content {
    float: right;
    width: 670px;
}

.modern-post {
    margin-bottom: 30px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 30px;
    position: relative;
    overflow: hidden;
}

.modern-post::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.modern-title {
    color: #2c3e50;
    font-size: 32px;
    margin-bottom: 15px;
    font-weight: 700;
    position: relative;
    padding-bottom: 15px;
}

.modern-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
}

.modern-subtitle {
    color: #7f8c8d;
    font-size: 18px;
    margin-top: 0;
    margin-bottom: 30px;
    font-weight: 400;
}

/* Filter and Search */
.filters-section {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    border: 1px solid #e1e8ed;
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
    color: #2c3e50;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e1e8ed;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn {
    padding: 12px 20px;
    border-radius: 10px;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
}

.btn-secondary {
    background: #f1f5f9;
    color: #2c3e50;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

/* Table Styles */
.table-container {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #e1e8ed;
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
    color: #2c3e50;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

th {
    background-color: #f8fafc;
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
    background-color: #f1f5f9;
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
    color: #667eea;
}

.view-btn:hover {
    background: rgba(102, 126, 234, 0.2);
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
    color: #2c3e50;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.pagination a:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.pagination .current {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.pagination .disabled {
    background: #f1f5f9;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
    cursor: not-allowed;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    color: #64748b;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 20px;
    color: #cbd5e1;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #2c3e50;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modern-content {
        width: 100%;
        float: none;
    }
    
    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .form-group {
        min-width: auto;
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
}
</style>

<div class="main-content">
    <div class="modern-post">
        <h1 class="modern-title">My Submitted Topics</h1>
        <p class="modern-subtitle">View and manage topics you've submitted</p>
        
        <!-- Filters Section -->
        <div class="filters-section">
            <form method="GET" action="">
                <div class="filter-row">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available" <?php echo ($statusFilter == 'available') ? 'selected' : ''; ?>>Available</option>
                            <option value="taken" <?php echo ($statusFilter == 'taken') ? 'selected' : ''; ?>>Taken</option>
                            <option value="completed" <?php echo ($statusFilter == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="search">Search Topics</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search by title or abstract..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <?php if ($statusFilter != 'available' || !empty($searchTerm)): ?>
                            <a href="user_topics.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Topics Table -->
        <div class="table-container">
            <div class="table-header">
                <h3>Submitted Topics</h3>
                <div>Showing <?php echo $result->num_rows; ?> of <?php echo $totalRecords; ?> topics</div>
            </div>
            
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Topic Title</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
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
                                            case 'available': echo 'Available'; break;
                                            case 'taken': echo 'Taken'; break;
                                            case 'completed': echo 'Completed'; break;
                                            default: echo ucfirst($topic['status']);
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($topic['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="view_user_topic.php?id=<?php echo $topic['id']; ?>" class="action-btn view-btn" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?page=1<?php echo ($statusFilter != 'available') ? '&status=' . $statusFilter : ''; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                <i class="fas fa-angle-double-left"></i> First
                            </a>
                            <a href="?page=<?php echo $currentPage - 1; ?><?php echo ($statusFilter != 'available') ? '&status=' . $statusFilter : ''; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
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
                                <a href="?page=<?php echo $i; ?><?php echo ($statusFilter != 'available') ? '&status=' . $statusFilter : ''; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?page=<?php echo $currentPage + 1; ?><?php echo ($statusFilter != 'available') ? '&status=' . $statusFilter : ''; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                Next <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $totalPages; ?><?php echo ($statusFilter != 'available') ? '&status=' . $statusFilter : ''; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
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
                    <i class="fas fa-book"></i>
                    <h3>No Topics Found</h3>
                    <p>There are no topics matching your current criteria.</p>
                    <a href="addtopic.php" class="btn btn-primary" style="margin-top: 20px;">
                        <i class="fas fa-plus"></i> Submit a Topic
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div><!-- end .main-content -->

<?php
include("includes/footer.php");
?>
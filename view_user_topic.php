<?php
// We include the header which starts the session, so we don't need to start it again
include("includes/connection.php");
include("includes/header.php");

// Check if user is logged in (after including header to ensure session is started)
if (!isset($_SESSION['client']['status'])) {
    header("location:login.php");
    exit();
}

// Get topic ID from URL
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($topic_id <= 0) {
    header("location:user_topics.php");
    exit();
}

// Get topic details for the current user only
$user_id = $_SESSION['client']['id']; // Get user ID from session
$stmt = $link->prepare("SELECT * FROM topics WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $topic_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("location:user_topics.php");
    exit();
}

$topic = $result->fetch_assoc();
?>

<style>
/* Enhanced Modern View Topic Styles */
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
    color: #2c3e50;
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
    color: #7f8c8d;
    margin-bottom: 5px;
}

.meta-value {
    font-weight: 600;
    color: #2c3e50;
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
    color: #2c3e50;
    margin: 30px 0 20px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.abstract-content {
    background: #f8fafc;
    border-radius: 10px;
    padding: 20px;
    white-space: pre-wrap;
    line-height: 1.8;
    color: #2c3e50;
    border: 1px solid #e2e8f0;
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
    border-radius: 10px;
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

.btn-back {
    background: #f1f5f9;
    color: #2c3e50;
    border: 1px solid #e2e8f0;
}

.btn-back:hover {
    background: #e2e8f0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modern-content {
        width: 100%;
        float: none;
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
    
    .topic-meta {
        flex-direction: column;
        gap: 15px;
    }
}
</style>

<div class="main-content">
    <div class="modern-post">
        <h1 class="modern-title">View Topic</h1>
        <p class="modern-subtitle">Review your submitted project topic</p>
        
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
                <?php 
                switch($topic['status']) {
                    case 'available': echo 'Available'; break;
                    case 'taken': echo 'Taken'; break;
                    case 'completed': echo 'Completed'; break;
                    default: echo ucfirst($topic['status']);
                }
                ?>
            </span>
        </div>
        
        <h3 class="section-title"><i class="fas fa-file-alt"></i> Project Abstract</h3>
        <div class="abstract-content">
            <?php echo nl2br(htmlspecialchars($topic['project_abstract'])); ?>
        </div>
        
        <?php if (!empty($topic['topic_text'])): ?>
            <h3 class="section-title"><i class="fas fa-align-left"></i> Topic Description</h3>
            <div class="abstract-content">
                <?php echo nl2br(htmlspecialchars($topic['topic_text'])); ?>
            </div>
        <?php endif; ?>
        
        <div class="actions">
            <a href="user_topics.php" class="action-btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to My Topics
            </a>
        </div>
    </div>
</div><!-- end .main-content -->

<?php
include("includes/footer.php");
?>
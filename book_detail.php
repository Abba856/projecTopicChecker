<?php
include("includes/header.php");
include("includes/connection.php");

$bid = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($bid > 0) {
    // Use prepared statement to prevent SQL injection
    $book_query = "SELECT * FROM topics WHERE id = ?";
    $stmt = $link->prepare($book_query);
    $stmt->bind_param("i", $bid);
    $stmt->execute();
    $book_res = $stmt->get_result();
    $book_row = $book_res->fetch_assoc();
    
    if (!$book_row) {
        header("location:index.php");
        exit();
    }
} else {
    header("location:index.php");
    exit();
}
?>

<style>
/* Enhanced Modern Book Detail Styles */
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

.topic-detail {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.topic-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 25px;
    border-bottom: 1px solid #eee;
    gap: 20px;
}

.topic-title {
    font-size: 28px;
    color: #2d3436;
    margin: 0;
    font-weight: 700;
    line-height: 1.3;
    flex: 1;
}

.topic-status {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.topic-status.available {
    background: linear-gradient(135deg, #00b09b, #96c93d);
    color: white;
}

.topic-status.taken {
    background: linear-gradient(135deg, #ff9a9e, #fecfef);
    color: #c0392b;
}

.topic-status.completed {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: #2c3e50;
}

.topic-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
}

.topic-section h3 {
    color: #667eea;
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 22px;
    font-weight: 600;
    position: relative;
    padding-bottom: 10px;
}

.topic-section h3::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: #667eea;
    border-radius: 2px;
}

.topic-abstract p {
    line-height: 1.7;
    color: #555;
    font-size: 16px;
    margin-bottom: 0;
}

.topic-meta {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.meta-item {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.meta-item h4 {
    color: #7f8c8d;
    margin: 0 0 10px 0;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.meta-item p {
    color: #2c3e50;
    margin: 0;
    font-size: 16px;
    font-weight: 500;
}

.actions {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.action-btn {
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.action-btn.secondary {
    background: #f8f9fa;
    color: #667eea;
    border: 2px solid #e9ecef;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
}

.action-btn.secondary:hover {
    background: #e9ecef;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.back-link {
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #eee;
}

.back-link a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.back-link a:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
}

.related-topics {
    margin-top: 40px;
}

.related-topics h3 {
    color: #2c3e50;
    font-size: 24px;
    margin-bottom: 25px;
    font-weight: 600;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.related-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border: 1px solid #eee;
}

.related-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
}

.related-card h4 {
    color: #2d3436;
    margin: 0 0 10px 0;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
}

.related-card .status {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .modern-content {
        width: 100%;
        float: none;
    }
    
    .topic-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .topic-meta {
        grid-template-columns: 1fr;
    }
    
    .related-grid {
        grid-template-columns: 1fr;
    }
    
    .actions {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .modern-post {
        padding: 20px;
    }
    
    .topic-title {
        font-size: 24px;
    }
    
    .topic-section {
        padding: 20px;
    }
    
    .related-topics h3 {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .modern-post {
        padding: 15px;
    }
    
    .topic-title {
        font-size: 22px;
    }
    
    .topic-section {
        padding: 15px;
    }
    
    .topic-abstract p {
        font-size: 15px;
    }
    
    .meta-item {
        padding: 15px;
    }
    
    .actions {
        gap: 10px;
    }
    
    .action-btn {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .back-link a {
        padding: 10px 15px;
        font-size: 14px;
        justify-content: center;
    }
}
</style>

<div class="main-content">
    <div class="modern-post">
        <h1 class="modern-title">Project Topic Details</h1>
        
        <div class="topic-detail">
            <div class="topic-header">
                <h1 class="topic-title"><?php echo htmlspecialchars($book_row['topic_title']); ?></h1>
                <span class="topic-status <?php echo htmlspecialchars($book_row['status']); ?>">
                    <?php echo htmlspecialchars($book_row['status']); ?>
                </span>
            </div>
            
            <div class="topic-section">
                <h3>Project Abstract</h3>
                <div class="topic-abstract">
                    <p><?php echo htmlspecialchars($book_row['project_abstract']); ?></p>
                </div>
            </div>
            
            <div class="topic-meta">
                <div class="meta-item">
                    <h4>Topic ID</h4>
                    <p>#<?php echo htmlspecialchars($book_row['id']); ?></p>
                </div>
                <div class="meta-item">
                    <h4>Date Added</h4>
                    <p><?php echo date('M j, Y', strtotime($book_row['created_at'])); ?></p>
                </div>
            </div>
            
            <!--<div class="actions">
                <a href="#" class="action-btn primary">
                    <i class="fas fa-download"></i>
                    Download PDF
                </a>
                <a href="#" class="action-btn secondary">
                    <i class="fas fa-bookmark"></i>
                    Save Topic
                </a>
                <a href="#" class="action-btn secondary">
                    <i class="fas fa-share-alt"></i>
                    Share
                </a>
            </div>-->
            
            <?php
            // Get related topics
            $relatedQuery = "SELECT * FROM topics WHERE id != ? ORDER BY RAND() LIMIT 4";
            $relatedStmt = $link->prepare($relatedQuery);
            $relatedStmt->bind_param("i", $bid);
            $relatedStmt->execute();
            $relatedRes = $relatedStmt->get_result();
            
            if ($relatedRes->num_rows > 0) {
                echo '<div class="related-topics">';
                echo '<h3>Related Topics</h3>';
                echo '<div class="related-grid">';
                
                while ($relatedRow = $relatedRes->fetch_assoc()) {
                    echo '<div class="related-card">';
                    echo '<h4>' . htmlspecialchars($relatedRow['topic_title']) . '</h4>';
                    echo '<span class="status ' . htmlspecialchars($relatedRow['status']) . '">' . htmlspecialchars($relatedRow['status']) . '</span>';
                    echo '</div>';
                }
                
                echo '</div>';
                echo '</div>';
            }
            ?>
            
            <div class="back-link">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i>
                    Back to All Topics
                </a>
            </div>
        </div>
    </div>
</div><!-- end .main-content -->

<?php
include("includes/footer.php");
?>

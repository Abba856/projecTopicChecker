<?php
include("includes/header.php");
?>

<style>
/* Enhanced Modern Homepage Styles */
.modern-content {
    width: 100%;
    float: none;
}

.modern-post {
    margin-bottom: 30px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 35px;
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
    font-size: 34px;
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

.topic-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-top: 20px;
}

.topic-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 25px 20px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid #eef2f7;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
    position: relative;
    overflow: hidden;
}

.topic-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.topic-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    border-color: #dfe6e9;
}

.topic-card:hover::before {
    transform: scaleX(1);
}

.topic-card h3 {
    color: #2d3436;
    margin: 0 0 15px 0;
    font-size: 18px;
    font-weight: 600;
    line-height: 1.4;
    transition: color 0.3s ease;
}

.topic-card .status {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.status.available {
    background: linear-gradient(135deg, #00b09b, #96c93d);
    color: white;
    box-shadow: 0 4px 10px rgba(0, 176, 155, 0.2);
}

.status.taken {
    background: linear-gradient(135deg, #ff9a9e, #fecfef);
    color: #c0392b;
    box-shadow: 0 4px 10px rgba(255, 154, 158, 0.2);
}

.status.completed {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: #2c3e50;
    box-shadow: 0 4px 10px rgba(79, 172, 254, 0.2);
}

.topic-card a {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.topic-card:hover h3 {
    color: #667eea;
}

.stats-container {
    display: flex;
    justify-content: space-between;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
    margin: 30px 0;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
}

.stat-item {
    text-align: center;
    flex: 1;
}

.stat-number {
    font-size: 30px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 15px;
    color: #7f8c8d;
    font-weight: 500;
}

.load-more {
    text-align: center;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.load-more-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 15px 35px;
    border-radius: 50px;
    cursor: pointer;
    font-size: 17px;
    font-weight: 600;
    transition: all 0.4s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    letter-spacing: 0.5px;
}

.load-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
}

.load-more-btn:active {
    transform: translateY(-1px);
}

.featured-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 30px;
    color: white;
    margin: 30px 0;
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.featured-title {
    font-size: 24px;
    margin-top: 0;
    margin-bottom: 15px;
    font-weight: 600;
}

.featured-text {
    font-size: 17px;
    line-height: 1.6;
    opacity: 0.9;
    margin-bottom: 0;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .topic-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .stats-container {
        flex-direction: column;
        gap: 15px;
    }
    
    .featured-section {
        padding: 25px;
    }
}

@media (max-width: 768px) {
    .topic-grid {
        grid-template-columns: 1fr;
    }
    
    .modern-post {
        padding: 25px;
    }
    
    .modern-title {
        font-size: 30px;
    }
    
    .modern-subtitle {
        font-size: 16px;
    }
    
    .stat-number {
        font-size: 26px;
    }
    
    .stat-label {
        font-size: 14px;
    }
    
    .featured-title {
        font-size: 22px;
    }
    
    .featured-text {
        font-size: 16px;
    }
    
    .load-more-btn {
        padding: 12px 25px;
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .topic-grid {
        gap: 15px;
    }
    
    .topic-card {
        padding: 20px 15px;
    }
    
    .modern-post {
        padding: 20px;
    }
    
    .modern-title {
        font-size: 26px;
    }
    
    .topic-card h3 {
        font-size: 16px;
    }
    
    .stat-item {
        padding: 15px;
    }
    
    .stat-number {
        font-size: 22px;
    }
    
    .featured-title {
        font-size: 20px;
    }
    
    .featured-text {
        font-size: 15px;
    }
    
    .load-more-btn {
        padding: 12px 20px;
        font-size: 15px;
    }
    
    .btn-primary {
        padding: 12px 20px;
        font-size: 15px;
        width: 100%;
        justify-content: center;
        margin-bottom: 10px;
    }
    
    .btn-primary:last-child {
        margin-bottom: 0;
    }
}
</style>

<div class="main-content">
    <div class="modern-post">
        <h1 class="modern-title">Project Topics</h1>
        <p class="modern-subtitle">Browse through our collection of project topics for your academic needs</p>
        
        <?php
            include("includes/connection.php");

            // Get statistics
            $totalQuery = "SELECT COUNT(*) as total FROM topics";
            $totalResult = $link->query($totalQuery);
            $totalRow = $totalResult->fetch_assoc();
            $totalTopics = $totalRow['total'];

            $availableQuery = "SELECT COUNT(*) as available FROM topics WHERE status = 'available'";
            $availableResult = $link->query($availableQuery);
            $availableRow = $availableResult->fetch_assoc();
            $availableTopics = $availableRow['available'];

            $takenQuery = "SELECT COUNT(*) as taken FROM topics WHERE status = 'taken'";
            $takenResult = $link->query($takenQuery);
            $takenRow = $takenResult->fetch_assoc();
            $takenTopics = $takenRow['taken'];
        ?>
        
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number"><?php echo $totalTopics; ?></div>
                <div class="stat-label">Total Topics</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $availableTopics; ?></div>
                <div class="stat-label">Available</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $takenTopics; ?></div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        
        <?php if(isset($_SESSION['client']['status'])): ?>
        <div style="text-align: center; margin: 30px 0;">
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="addtopic.php" class="btn-primary" style="display: inline-block; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-size: 18px; font-weight: 600;">
                    <i class="fas fa-plus-circle"></i> Submit Your Project Topic
                </a>
                <a href="user_topics.php" style="display: inline-block; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-size: 18px; font-weight: 600; background: #f1f5f9; color: #2c3e50; border: 1px solid #e2e8f0;">
                    <i class="fas fa-book"></i> View My Topics
                </a>
            </div>
            <p style="margin-top: 15px; color: #666;">Share your project ideas or view your submissions</p>
        </div>
        <?php endif; ?>
        
        <div class="featured-section">
            <h2 class="featured-title">Featured Project Topics</h2>
            <p class="featured-text">Discover the most popular and trending project topics selected by our academic advisors. These topics are in high demand and offer excellent learning opportunities.</p>
        </div>
        
        <div class="topic-grid">
            <?php
                $lq = "SELECT * FROM topics ORDER BY RAND() LIMIT 9";
                $lres = $link->query($lq);

                if ($lres) {
                    while ($lrow = $lres->fetch_assoc()) {
                        echo '<div class="topic-card">
                                <a href="book_detail.php?id=' . $lrow['id'] . '">
                                    <h3>' . htmlspecialchars($lrow['topic_title']) . '</h3>
                                    <span class="status ' . htmlspecialchars($lrow['status']) . '">' . htmlspecialchars($lrow['status']) . '</span>
                                </a>
                              </div>';
                    }
                }
            ?>
        </div>
        
        <div class="load-more">
            <button class="load-more-btn">Load More Topics</button>
        </div>
    </div>
</div><!-- end .main-content -->

<script>
// Add animation to load more button
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.querySelector('.load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            this.innerHTML = 'Loading...';
            this.disabled = true;
            
            // Simulate loading (in a real app, this would fetch more data)
            setTimeout(() => {
                this.innerHTML = 'Load More Topics';
                this.disabled = false;
                
                // Add animation effect
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            }, 1000);
        });
    }
});
</script>

<?php
include("includes/footer.php");
?>
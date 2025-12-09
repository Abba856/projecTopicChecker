<?php
include("includes/header.php");
?>

<style>
/* Enhanced Modern Search Styles */
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

.search-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.search-form {
    display: flex;
    gap: 15px;
    flex: 1;
    max-width: 500px;
}

.search-input {
    flex: 1;
    padding: 14px 20px;
    border: 2px solid #e1e8ed;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
    background: #f8f9fa;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.search-btn {
    padding: 14px 25px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.search-results-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    color: #1565c0;
    font-weight: 500;
    box-shadow: 0 3px 10px rgba(19, 120, 204, 0.15);
}

.search-results-info strong {
    font-weight: 700;
}

.topic-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 25px;
    margin-top: 20px;
}

.topic-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 25px;
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
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    border-color: #dfe6e9;
}

.topic-card:hover::before {
    transform: scaleX(1);
}

.topic-card h3 {
    color: #2d3436;
    margin: 0 0 15px 0;
    font-size: 20px;
    font-weight: 700;
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
    margin-bottom: 15px;
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

.topic-card .abstract {
    color: #555;
    line-height: 1.7;
    margin-bottom: 20px;
    font-size: 15px;
}

.topic-card a {
    text-decoration: none;
    color: inherit;
    display: block;
}

.topic-card:hover h3 {
    color: #667eea;
}

.view-details {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.view-details:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.no-results {
    text-align: center;
    padding: 60px 30px;
    background: #f8f9fa;
    border-radius: 12px;
    color: #666;
    margin: 30px 0;
}

.no-results i {
    font-size: 48px;
    color: #95a5a6;
    margin-bottom: 20px;
}

.no-results h3 {
    color: #2c3e50;
    font-size: 24px;
    margin: 0 0 15px 0;
    font-weight: 600;
}

.no-results p {
    font-size: 16px;
    line-height: 1.6;
    margin: 0 0 25px 0;
}

.suggestions {
    background: #e8f4f8;
    border-radius: 12px;
    padding: 25px;
    margin-top: 30px;
}

.suggestions h4 {
    color: #2c3e50;
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 600;
}

.suggestion-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.suggestion-tag {
    background: white;
    color: #667eea;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
}

.suggestion-tag:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
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

/* Responsive adjustments */
@media (max-width: 992px) {
    .modern-content {
        width: 100%;
        float: none;
    }
    
    .search-header {
        flex-direction: column;
        gap: 20px;
        align-items: stretch;
    }
    
    .search-form {
        max-width: 100%;
    }
    
    .topic-grid {
        grid-template-columns: repeat(1, 1fr);
    }
    
    .suggestion-tags {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .modern-post {
        padding: 20px;
    }
    
    .modern-title {
        font-size: 28px;
    }
    
    .search-input {
        padding: 12px 16px;
        font-size: 15px;
    }
    
    .search-btn {
        padding: 12px 20px;
        font-size: 15px;
    }
    
    .search-results-info {
        padding: 15px;
        font-size: 15px;
    }
    
    .topic-card {
        padding: 20px;
    }
    
    .topic-card h3 {
        font-size: 18px;
    }
    
    .view-details {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .suggestions {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .modern-post {
        padding: 15px;
    }
    
    .modern-title {
        font-size: 24px;
    }
    
    .search-header {
        gap: 15px;
    }
    
    .search-form {
        flex-direction: column;
        gap: 10px;
    }
    
    .search-input {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .search-btn {
        padding: 12px;
        font-size: 14px;
    }
    
    .search-results-info {
        padding: 12px;
        font-size: 14px;
    }
    
    .topic-card {
        padding: 15px;
    }
    
    .topic-card h3 {
        font-size: 16px;
    }
    
    .topic-card .abstract {
        font-size: 14px;
    }
    
    .view-details {
        padding: 10px 15px;
        font-size: 14px;
        width: 100%;
        justify-content: center;
    }
    
    .suggestions {
        padding: 15px;
    }
    
    .suggestion-tag {
        padding: 8px 15px;
        font-size: 14px;
    }
    
    .back-link a {
        padding: 10px 15px;
        font-size: 14px;
        justify-content: center;
    }
    
    .no-results {
        padding: 40px 15px;
    }
    
    .no-results i {
        font-size: 36px;
    }
    
    .no-results h3 {
        font-size: 20px;
    }
    
    .no-results p {
        font-size: 14px;
    }
}
</style>

<div class="main-content">
    <div class="modern-post">
        <h1 class="modern-title">Search Results</h1>
        
        <div class="search-header">
            <form method="get" action="search.php" class="search-form">
                <input type="text" name="s" class="search-input" placeholder="Search project topics..." value="<?php echo isset($_GET['s']) ? htmlspecialchars($_GET['s']) : ''; ?>" required>
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>
        
        <?php
            include("includes/connection.php");

            if (isset($_GET['s'])) {
                $s = $_GET['s'];
                echo '<div class="search-results-info">';
                echo 'Search results for: <strong>' . htmlspecialchars($s) . '</strong>';
                echo '</div>';
                
                // Use prepared statement to prevent SQL injection
                $blq = "SELECT * FROM topics WHERE topic_title LIKE ?";
                $search_term = "%".$s."%";
                $stmt = $link->prepare($blq);
                $stmt->bind_param("s", $search_term);
                $stmt->execute();
                $blres = $stmt->get_result();

                if ($blres->num_rows > 0) {
                    echo '<div class="topic-grid">';
                    while($blrow = $blres->fetch_assoc()) {
                        echo '<div class="topic-card">
                                <a href="book_detail.php?id=' . $blrow['id'] . '">
                                    <h3>' . htmlspecialchars($blrow['topic_title']) . '</h3>
                                    <span class="status ' . htmlspecialchars($blrow['status']) . '">' . htmlspecialchars($blrow['status']) . '</span>
                                    <div class="abstract">' . htmlspecialchars(substr($blrow['project_abstract'], 0, 200)) . '...</div>
                                    <span class="view-details">
                                        <i class="fas fa-eye"></i>
                                        View Details
                                    </span>
                                </a>
                              </div>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="no-results">
                            <i class="fas fa-search"></i>
                            <h3>No Results Found</h3>
                            <p>Sorry, we couldn\'t find any project topics matching your search for "' . htmlspecialchars($s) . '".</p>
                            <p>Try adjusting your search terms or browse our popular topics below.</p>
                          </div>';
                    
                    // Show suggestions
                    echo '<div class="suggestions">
                            <h4>Popular Search Terms</h4>
                            <div class="suggestion-tags">
                                <a href="search.php?s=Management" class="suggestion-tag">Management</a>
                                <a href="search.php?s=System" class="suggestion-tag">System</a>
                                <a href="search.php?s=Online" class="suggestion-tag">Online</a>
                                <a href="search.php?s=Website" class="suggestion-tag">Website</a>
                                <a href="search.php?s=Application" class="suggestion-tag">Application</a>
                            </div>
                          </div>';
                }
            } else {
                echo '<div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>Search Required</h3>
                        <p>Please enter a search term to find project topics.</p>
                        <p>Try searching for topics like "Management System", "Online Platform", or "Web Application".</p>
                      </div>';
                
                // Show suggestions
                echo '<div class="suggestions">
                        <h4>Popular Search Terms</h4>
                        <div class="suggestion-tags">
                            <a href="search.php?s=Management" class="suggestion-tag">Management</a>
                            <a href="search.php?s=System" class="suggestion-tag">System</a>
                            <a href="search.php?s=Online" class="suggestion-tag">Online</a>
                            <a href="search.php?s=Website" class="suggestion-tag">Website</a>
                            <a href="search.php?s=Application" class="suggestion-tag">Application</a>
                        </div>
                      </div>';
            }
        ?>
        
        <div class="back-link">
            <a href="index.php">
                <i class="fas fa-arrow-left"></i>
                Back to All Topics
            </a>
        </div>
    </div>
</div><!-- end .main-content -->

<?php
include("includes/footer.php");
?>
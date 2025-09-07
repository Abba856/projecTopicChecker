</div><!-- end .main-content -->

<aside class="sidebar">
    <?php
    if (isset($_SESSION['client']['status'])) {
        echo '<div class="sidebar-widget user-widget">';
        echo '<h3 class="widget-title"><i class="fas fa-user-circle"></i> Welcome Back</h3>';
        echo '<div class="user-info">';
        echo '<div class="user-avatar">';
        echo '<i class="fas fa-user-circle"></i>';
        echo '</div>';
        echo '<p class="user-name">' . htmlspecialchars($_SESSION['client']['unm']) . '</p>';
        echo '<a href="logout.php" class="sidebar-logout-btn">';
        echo '<i class="fas fa-sign-out-alt"></i> Log Out';
        echo '</a>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    
    <div class="sidebar-widget">
        <h3 class="widget-title"><i class="fas fa-clock"></i> Recently Added</h3>
        <div class="recent-topics">
            <?php
            // Get the database connection
            if (!isset($link) || !$link) {
                include("includes/connection.php");
            }

            // Ensure we have a valid connection
            if (isset($link) && $link) {
                $cat_q = "SELECT id, topic_title, status, created_at FROM topics ORDER BY id DESC LIMIT 0,8";
                $cat_res = $link->query($cat_q);

                if ($cat_res && $cat_res->num_rows > 0) {
                    echo '<ul class="recent-list">';
                    while ($cat_row = $cat_res->fetch_assoc()) {
                        echo '<li class="recent-item">';
                        echo '<a href="book_detail.php?id=' . $cat_row['id'] . '" class="recent-link">';
                        echo '<div class="recent-content">';
                        echo '<h4 class="recent-title">' . htmlspecialchars($cat_row['topic_title']) . '</h4>';
                        echo '<div class="recent-meta">';
                        echo '<span class="topic-status ' . htmlspecialchars($cat_row['status']) . '">';
                        echo '<i class="fas fa-circle status-icon"></i>';
                        echo htmlspecialchars($cat_row['status']);
                        echo '</span>';
                        echo '<span class="recent-date">' . date('M j', strtotime($cat_row['created_at'])) . '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<div class="no-topics">';
                    echo '<i class="fas fa-book-open"></i>';
                    echo '<p>No topics available yet.</p>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-topics">';
                echo '<i class="fas fa-exclamation-triangle"></i>';
                echo '<p>Database connection error.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    
    <div class="sidebar-widget newsletter-widget">
        <h3 class="widget-title"><i class="fas fa-bell"></i> Stay Updated</h3>
        <div class="newsletter-content">
            <p>Get notified when new project topics are added.</p>
            <form class="newsletter-form">
                <div class="form-group">
                    <input type="email" placeholder="Your email address" required>
                </div>
                <button type="submit" class="subscribe-btn">
                    <i class="fas fa-paper-plane"></i>
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</aside><!-- end .sidebar -->

</div><!-- end .page-container -->

<footer class="modern-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section about-section">
                <h3><i class="fas fa-graduation-cap"></i> Project Topic Checker</h3>
                <p>A comprehensive system for managing and exploring academic project topics at Kano State Polytechnic.</p>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> Matan fada, Kano</p>
                    <p><i class="fas fa-envelope"></i> info@kanopoly.edu.ng</p>
                </div>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-section links-section">
                <h4><i class="fas fa-link"></i> Quick Links</h4>
                <ul>
                    <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <?php if (isset($_SESSION['client']['status'])): ?>
                        <li><a href="logout.php"><i class="fas fa-chevron-right"></i> Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php"><i class="fas fa-chevron-right"></i> Login</a></li>
                        <li><a href="register.php"><i class="fas fa-chevron-right"></i> Register</a></li>
                    <?php endif; ?>
                    <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                    <li><a href="search.php"><i class="fas fa-chevron-right"></i> Browse Topics</a></li>
                </ul>
            </div>
            
            <div class="footer-section categories-section">
                <h4><i class="fas fa-tags"></i> Popular Categories</h4>
                <ul>
                    <li><a href="search.php?s=Management"><i class="fas fa-chevron-right"></i> Management Systems</a></li>
                    <li><a href="search.php?s=Online"><i class="fas fa-chevron-right"></i> Online Platforms</a></li>
                    <li><a href="search.php?s=Website"><i class="fas fa-chevron-right"></i> Websites</a></li>
                    <li><a href="search.php?s=Application"><i class="fas fa-chevron-right"></i> Applications</a></li>
                    <li><a href="search.php?s=Database"><i class="fas fa-chevron-right"></i> Database Projects</a></li>
                    <li><a href="search.php?s=Mobile"><i class="fas fa-chevron-right"></i> Mobile Apps</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; 2025 Project Topic Checker. All rights reserved.</p>
                <p>Project Made By <a href="index.php" rel="nofollow"><strong>ISAH ABDULLAHI ISAH</strong></a> with Matric No. HND/SWD/23/0107.</p>
            </div>
        </div>
    </div>
</footer>

<style>
/* Refined Modern Footer Styles */
.sidebar {
    width: 320px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    padding: 30px;
    height: fit-content;
    border: 1px solid rgba(0, 0, 0, 0.05);
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

.sidebar-widget {
    margin-bottom: 35px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eef2f7;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 30px;
    position: relative;
    overflow: hidden;
}

.sidebar-widget::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.sidebar-widget:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.widget-title {
    color: #2c3e50;
    font-size: 22px;
    margin-bottom: 25px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    padding-bottom: 15px;
}

.widget-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
}

.widget-title i {
    color: #667eea;
    font-size: 20px;
}

/* User Widget */
.user-widget {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    border: none;
    margin-bottom: 35px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.user-widget::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: rgba(255, 255, 255, 0.3);
}

.user-widget .widget-title {
    color: white;
    margin-bottom: 20px;
    padding-bottom: 0;
}

.user-widget .widget-title::after {
    display: none;
}

.user-avatar {
    text-align: center;
    margin-bottom: 20px;
}

.user-avatar i {
    font-size: 48px;
    color: rgba(255, 255, 255, 0.9);
}

.user-name {
    text-align: center;
    font-size: 20px;
    font-weight: 600;
    margin: 0 0 25px 0;
    color: white;
}

.sidebar-logout-btn {
    display: block;
    width: 100%;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
    text-align: center;
}

.sidebar-logout-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Recent Topics */
.recent-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-item {
    margin-bottom: 18px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.recent-item:last-child {
    margin-bottom: 0;
}

.recent-link {
    display: block;
    text-decoration: none;
    color: inherit;
    border-radius: 10px;
    padding: 15px;
    background: #f8f9fa;
    border: 1px solid #eef2f7;
    transition: all 0.3s ease;
}

.recent-link:hover {
    background: #e8f4f8;
    border-color: #667eea;
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.recent-content {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.recent-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.recent-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
}

.topic-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 5px;
}

.topic-status.available {
    background: #e8f5e9;
    color: #2e7d32;
}

.topic-status.taken {
    background: #fff3e0;
    color: #ef6c00;
}

.topic-status.completed {
    background: #e3f2fd;
    color: #1565c0;
}

.status-icon {
    font-size: 6px;
}

.recent-date {
    color: #7f8c8d;
    font-weight: 500;
}

.no-topics {
    text-align: center;
    color: #7f8c8d;
    padding: 30px 20px;
}

.no-topics i {
    font-size: 32px;
    color: #bdc3c7;
    margin-bottom: 15px;
}

.no-topics p {
    margin: 0;
    font-style: italic;
}

/* Quick Stats */
.stats-widget .quick-stats {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-top: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    border: 1px solid #eef2f7;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    border-color: #667eea;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.stat-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.stat-content {
    flex: 1;
}

.stat-number {
    display: block;
    font-size: 22px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 3px;
    line-height: 1;
}

.stat-label {
    font-size: 13px;
    color: #7f8c8d;
    font-weight: 500;
    margin: 0;
}

/* Newsletter Widget */
.newsletter-content p {
    color: #555;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 20px;
}

.newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e1e8ed;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.subscribe-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.subscribe-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

/* Footer */
.modern-footer {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    margin-top: 60px;
    padding: 60px 0 0;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    padding-bottom: 40px;
}

.footer-section h3 {
    font-size: 24px;
    margin-bottom: 25px;
    font-weight: 700;
    color: white;
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-section h4 {
    font-size: 20px;
    margin-bottom: 25px;
    font-weight: 600;
    color: white;
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    padding-bottom: 15px;
}

.footer-section h4::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 3px;
    background: #667eea;
    border-radius: 2px;
}

.footer-section p {
    color: #bdc3c7;
    line-height: 1.7;
    margin-bottom: 20px;
    font-size: 15px;
}

.contact-info p {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 14px;
}

.contact-info p:last-child {
    margin-bottom: 0;
}

.social-links {
    display: flex;
    gap: 15px;
    margin-top: 25px;
}

.social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 16px;
}

.social-links a:hover {
    background: #667eea;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.footer-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-section ul li {
    margin-bottom: 15px;
}

.footer-section ul li:last-child {
    margin-bottom: 0;
}

.footer-section ul li a {
    color: #bdc3c7;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px 0;
}

.footer-section ul li a:hover {
    color: white;
    padding-left: 8px;
}

.footer-section ul li a i {
    font-size: 12px;
    color: #667eea;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 25px 0;
}

.footer-bottom-content {
    text-align: center;
}

.footer-bottom-content p {
    color: #bdc3c7;
    margin: 5px 0;
    font-size: 14px;
}

.footer-bottom-content a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.footer-bottom-content a:hover {
    text-decoration: underline;
}

.footer-bottom-content strong {
    color: white;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .sidebar {
        width: 280px;
        padding: 25px;
    }
    
    .footer-content {
        gap: 30px;
    }
}

@media (min-width: 993px) {
    .sidebar {
        width: 100%;
    }
}

@media (max-width: 992px) {
    .sidebar {
        width: 100%;
        margin-top: 30px;
        position: static;
        order: 2;
    }
    
    .footer-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .footer-section h3,
    .footer-section h4 {
        font-size: 22px;
    }
}

@media (max-width: 768px) {
    .sidebar {
        padding: 20px;
    }
    
    .widget-title {
        font-size: 20px;
    }
    
    .user-name {
        font-size: 18px;
    }
    
    .stat-item {
        padding: 12px;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .stat-number {
        font-size: 20px;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .modern-footer {
        padding: 40px 0 0;
    }
    
    .footer-container {
        padding: 0 15px;
    }
}

@media (max-width: 480px) {
    .sidebar {
        padding: 15px;
    }
    
    .widget-title {
        font-size: 18px;
        gap: 10px;
    }
    
    .recent-link {
        padding: 12px;
    }
    
    .recent-title {
        font-size: 14px;
    }
    
    .footer-section h3,
    .footer-section h4 {
        font-size: 20px;
    }
    
    .footer-section ul li a {
        font-size: 14px;
    }
    
    .social-links a {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .footer-bottom-content p {
        font-size: 13px;
    }
}
</style>

<script>
// Add interactivity to sidebar widgets
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to recent items
    const recentItems = document.querySelectorAll('.recent-item');
    recentItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
    
    // Add animation to stat items
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach((item, index) => {
        item.style.animationDelay = (index * 0.1) + 's';
    });
    
    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            const subscribeBtn = this.querySelector('.subscribe-btn');
            
            // Simple validation
            if (emailInput.value && emailInput.value.includes('@')) {
                // Simulate submission
                const originalText = subscribeBtn.innerHTML;
                subscribeBtn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
                subscribeBtn.style.background = 'linear-gradient(135deg, #27ae60, #2ecc71)';
                
                setTimeout(() => {
                    subscribeBtn.innerHTML = originalText;
                    subscribeBtn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    emailInput.value = '';
                }, 2000);
            } else {
                emailInput.style.borderColor = '#e74c3c';
                setTimeout(() => {
                    emailInput.style.borderColor = '#e1e8ed';
                }, 2000);
            }
        });
    }
});
</script>

</body>
</html>

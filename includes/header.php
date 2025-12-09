<?php
	session_start();
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project Topic Checker</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* Modern Header Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    color: #333;
    line-height: 1.6;
}

.modern-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.logo-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 5%;
    max-width: 1200px;
    margin: 0 auto;
}

.logo-section h1 a {
    color: white;
    text-decoration: none;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.logo-section h2 {
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    font-weight: 400;
    margin-top: 5px;
}

.navigation {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 5%;
    max-width: 1200px;
    margin: 0 auto;
}

.main-menu {
    display: flex;
    list-style: none;
}

.main-menu li {
    position: relative;
}

.main-menu a {
    display: block;
    padding: 20px 20px;
    color: #2c3e50;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.main-menu a:hover {
    color: #667eea;
}

.main-menu a::after {
    content: "";
    position: absolute;
    bottom: 15px;
    left: 20px;
    width: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.main-menu a:hover::after {
    width: calc(100% - 40px);
}

.main-menu .current_page_item a {
    color: #667eea;
    font-weight: 600;
}

.main-menu .current_page_item a::after {
    width: calc(100% - 40px);
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.user-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-greeting {
    background: #e8f4f8;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    color: #667eea;
    display: flex;
    align-items: center;
    gap: 8px;
}

.logout-btn {
    background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
}

.login-btn, .register-btn {
    padding: 8px 15px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.login-btn {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border: 1px solid rgba(102, 126, 234, 0.3);
}

.login-btn:hover {
    background: rgba(102, 126, 234, 0.2);
}

.register-btn {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.register-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.modern-search {
    position: relative;
}

.modern-search input {
    padding: 10px 15px 10px 40px;
    border: 2px solid #e1e8ed;
    border-radius: 25px;
    font-size: 14px;
    width: 200px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.modern-search input:focus {
    outline: none;
    width: 250px;
    border-color: #667eea;
    background: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.modern-search i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #7f8c8d;
}

.page-container {
    display: flex;
    flex-direction: column;
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
    gap: 30px;
}

.main-content {
    flex: 1;
    min-width: 0;
}

/* Mobile Menu Toggle */
.menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 21px;
    cursor: pointer;
    padding: 5px;
}

.menu-toggle span {
    height: 3px;
    width: 100%;
    background: white;
    border-radius: 10px;
    transition: all 0.3s ease;
    transform-origin: center;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .logo-section {
        flex-direction: column;
        text-align: center;
        gap: 10px;
        padding: 15px 20px;
    }
    
    .nav-container {
        flex-direction: column;
        gap: 15px;
        padding: 15px 10px;
    }
    
    .main-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        flex-direction: column;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 20px 0;
    }
    
    .main-menu.active {
        display: flex;
    }
    
    .main-menu li {
        width: 100%;
    }
    
    .main-menu a {
        padding: 15px 20px;
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .menu-toggle {
        display: flex;
        position: absolute;
        top: 20px;
        right: 20px;
    }
    
    .user-actions {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .modern-search {
        width: 100%;
        margin-top: 15px;
        display: flex;
        justify-content: center;
    }
    
    .modern-search input {
        width: 100%;
        max-width: 300px;
    }
    
    .logo-section h1 a {
        font-size: 26px;
    }
}

@media (max-width: 768px) {
    .page-container {
        padding: 0 15px;
        margin: 20px auto;
        gap: 20px;
    }
    
    .logo-section h1 a {
        font-size: 24px;
    }
    
    .logo-section h2 {
        font-size: 14px;
    }
    
    .main-menu a {
        font-size: 16px;
        padding: 12px 20px;
    }
}

@media (max-width: 480px) {
    .logo-section {
        padding: 10px 15px;
    }
    
    .logo-section h1 a {
        font-size: 22px;
    }
    
    .logo-section h2 {
        font-size: 12px;
    }
    
    .main-menu a {
        font-size: 15px;
        padding: 12px 15px;
    }
    
    .user-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .user-greeting, .login-btn, .register-btn {
        width: 100%;
        justify-content: center;
        text-align: center;
    }
    
    .page-container {
        padding: 0 10px;
        margin: 15px auto;
        gap: 15px;
    }
}
</style>

</head>
<body>
    <header class="modern-header">
        <div class="logo-section">
            <div class="logo-text">
                <h1><a href="index.php">Project Topic Checker</a></h1>
                <h2>Kano State Polytechnic</h2>
            </div>
        </div>
    </header>
    
    <nav class="navigation">
        <div class="nav-container">
            <div class="menu-toggle" id="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="main-menu">
                <li><a href="index.php" class="first">Home</a></li>
                
                <?php
                    if(isset($_SESSION['client']['status'])) {
                        echo '<li><a href="addtopic.php">Upload Topic</a></li>';
                        echo '<li><a href="user_topics.php">My Topics</a></li>';
                    }
                ?>
                
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
            
            <div class="user-actions">
                <?php 
                    if(isset($_SESSION['client']['status'])) {
                        echo '<div class="user-greeting">';
                        echo '<i class="fas fa-user-circle"></i>';
                        echo 'Hi, ' . htmlspecialchars($_SESSION['client']['unm']);
                        echo '</div>';
                        echo '<a href="logout.php" class="logout-btn">';
                        echo '<i class="fas fa-sign-out-alt"></i>';
                        echo 'Logout';
                        echo '</a>';
                    } else {
                        echo '<a href="login.php" class="login-btn">';
                        echo '<i class="fas fa-sign-in-alt"></i>';
                        echo 'Login';
                        echo '</a>';
                        echo '<a href="register.php" class="register-btn">';
                        echo '<i class="fas fa-user-plus"></i>';
                        echo 'Register';
                        echo '</a>';
                    }
                ?>
            </div>
            
            <div class="modern-search">
                <form method="get" action="search.php">
                    <i class="fas fa-search"></i>
                    <input type="text" name="s" placeholder="Search topics..." />
                </form>
            </div>
        </div>
    </nav>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const mainMenu = document.querySelector('.main-menu');
            
            mobileMenu.addEventListener('click', function() {
                mainMenu.classList.toggle('active');
            });
            
            // Close menu when clicking on a link
            const menuLinks = document.querySelectorAll('.main-menu a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        mainMenu.classList.remove('active');
                    }
                });
            });
            
            // Close menu when resizing to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    mainMenu.classList.remove('active');
                }
            });
        });
    </script>
    
    <div class="page-container">
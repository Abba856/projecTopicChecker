<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookWorm - Online Book Recommendation System</title>
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
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 10px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
        }

        .nav-menu li {
            margin-left: 25px;
        }

        .nav-menu a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .nav-menu a:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #fff;
            color: #667eea;
        }

        .btn-primary:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(102, 126, 234, 0.8), rgba(118, 74, 162, 0.8)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1953&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 100px 20px;
            margin-bottom: 50px;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .search-box {
            max-width: 600px;
            margin: 40px auto;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 15px 20px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .search-box button {
            position: absolute;
            right: 5px;
            top: 5px;
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .search-box button:hover {
            background: #5a6fd8;
        }

        /* Categories Section */
        .section {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 15px;
            position: relative;
        }

        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 15px auto;
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
            padding: 30px 20px;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .category-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .category-description {
            color: #666;
            margin-bottom: 20px;
        }

        .category-link {
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 20px;
            border: 2px solid #667eea;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .category-link:hover {
            background: #667eea;
            color: white;
        }

        /* Featured Books */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .book-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .book-image {
            height: 300px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
        }

        .book-content {
            padding: 20px;
        }

        .book-category {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .book-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .book-author {
            color: #666;
            margin-bottom: 15px;
            font-style: italic;
        }

        .book-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .book-actions {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: #667eea;
            color: white;
        }

        .btn-view:hover {
            background: #5a6fd8;
        }

        .btn-wishlist {
            background: #fff;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-wishlist:hover {
            background: #667eea;
            color: white;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 60px 20px 30px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: #667eea;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #667eea;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #667eea;
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 40px;
            margin-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #bdc3c7;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }

            .nav-menu {
                margin: 15px 0;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .section {
                padding: 40px 20px;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-menu li {
                margin: 5px 10px;
            }

            .auth-buttons {
                flex-direction: column;
                width: 100%;
                gap: 10px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <i class="fas fa-book-reader"></i>
                BookWorm
            </a>
            
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="book_list.php">Books</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if(!empty($_SESSION['unm'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
            
            <div class="auth-buttons">
                <?php if(empty($_SESSION['unm'])): ?>
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="register.php" class="btn btn-primary">Register</a>
                <?php else: ?>
                    <span>Welcome, <?php echo $_SESSION['unm']; ?>!</span>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Discover Your Next Favorite Book</h1>
            <p>Explore thousands of books across various genres. Find recommendations tailored just for you.</p>
            
            <div class="search-box">
                <form action="search.php" method="GET">
                    <input type="text" name="q" placeholder="Search for books, authors, or genres...">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Browse Categories</h2>
            <p class="section-subtitle">Find books in your favorite genres</p>
        </div>
        
        <div class="categories-grid">
            <!-- Category cards would be generated dynamically from database -->
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3 class="category-name">Fiction</h3>
                <p class="category-description">Explore our collection of fiction books</p>
                <a href="book_list.php?cat=1" class="category-link">Browse Books</a>
            </div>
            
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="category-name">Non-Fiction</h3>
                <p class="category-description">Discover informative non-fiction titles</p>
                <a href="book_list.php?cat=2" class="category-link">Browse Books</a>
            </div>
            
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-user-secret"></i>
                </div>
                <h3 class="category-name">Mystery</h3>
                <p class="category-description">Solve puzzles with our mystery collection</p>
                <a href="book_list.php?cat=3" class="category-link">Browse Books</a>
            </div>
            
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="category-name">Romance</h3>
                <p class="category-description">Fall in love with our romance novels</p>
                <a href="book_list.php?cat=4" class="category-link">Browse Books</a>
            </div>
        </div>
    </section>

    <!-- Featured Books Section -->
    <section class="section" style="background-color: #f0f4f8;">
        <div class="section-header">
            <h2 class="section-title">Featured Books</h2>
            <p class="section-subtitle">Handpicked recommendations for you</p>
        </div>
        
        <div class="books-grid">
            <!-- Book cards would be generated dynamically from database -->
            <div class="book-card">
                <div class="book-image">
                    <i class="fas fa-book"></i>
                </div>
                <div class="book-content">
                    <span class="book-category">Fiction</span>
                    <h3 class="book-title">The Great Adventure</h3>
                    <p class="book-author">By John Author</p>
                    <div class="book-price">$19.99</div>
                    <div class="book-actions">
                        <a href="book_detail.php?id=1" class="btn-small btn-view">View Details</a>
                        <a href="#" class="btn-small btn-wishlist">
                            <i class="far fa-heart"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="book-card">
                <div class="book-image">
                    <i class="fas fa-book"></i>
                </div>
                <div class="book-content">
                    <span class="book-category">Mystery</span>
                    <h3 class="book-title">The Hidden Secret</h3>
                    <p class="book-author">By Jane Writer</p>
                    <div class="book-price">$24.99</div>
                    <div class="book-actions">
                        <a href="book_detail.php?id=2" class="btn-small btn-view">View Details</a>
                        <a href="#" class="btn-small btn-wishlist">
                            <i class="far fa-heart"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="book-card">
                <div class="book-image">
                    <i class="fas fa-book"></i>
                </div>
                <div class="book-content">
                    <span class="book-category">Romance</span>
                    <h3 class="book-title">Love in the City</h3>
                    <p class="book-author">By Sam Romance</p>
                    <div class="book-price">$17.99</div>
                    <div class="book-actions">
                        <a href="book_detail.php?id=3" class="btn-small btn-view">View Details</a>
                        <a href="#" class="btn-small btn-wishlist">
                            <i class="far fa-heart"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3>BookWorm</h3>
                <p>Your ultimate destination for discovering amazing books and getting personalized recommendations.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="book_list.php">Books</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Categories</h3>
                <ul class="footer-links">
                    <li><a href="book_list.php?cat=1">Fiction</a></li>
                    <li><a href="book_list.php?cat=2">Non-Fiction</a></li>
                    <li><a href="book_list.php?cat=3">Mystery</a></li>
                    <li><a href="book_list.php?cat=4">Romance</a></li>
                    <li><a href="book_list.php?cat=5">Sci-Fi</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Contact Info</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Library Street, Book City</li>
                    <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                    <li><i class="fas fa-envelope"></i> info@bookworm.com</li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2023 BookWorm. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
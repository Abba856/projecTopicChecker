<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Topic Checker - Contact Us</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Enhanced Modern Contact Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxjaXJjbGUgY3g9IjMwIiBjeT0iMzAiIHI9IjAuNSIgZmlsbD0iI2ZmZiIgZmlsbC1vcGFjaXR5PSIwLjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybikiLz48L3N2Zz4=');
            opacity: 0.3;
        }

        .contact-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            padding: 50px 40px;
            width: 100%;
            max-width: 650px;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        .contact-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .logo-modern {
            margin-bottom: 30px;
            position: relative;
        }

        .logo-modern h1 {
            color: #2c3e50;
            font-size: 32px;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo-modern h2 {
            color: #7f8c8d;
            font-size: 18px;
            margin: 8px 0 0 0;
            font-weight: 400;
        }

        .contact-header {
            margin-bottom: 40px;
        }

        .contact-header h1 {
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 700;
            position: relative;
        }

        .contact-header h1::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .contact-header p {
            color: #7f8c8d;
            font-size: 18px;
            margin: 0;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
            font-size: 18px;
        }

        .modern-input {
            width: 100%;
            padding: 16px 16px 16px 45px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-sizing: border-box;
            background: #ffffff;
            color: #2c3e50;
            font-weight: 500;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .modern-input:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
        }

        .modern-input::placeholder {
            color: #95a5a6;
            font-weight: 400;
        }

        .modern-textarea {
            width: 100%;
            padding: 16px 16px 16px 45px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-sizing: border-box;
            background: #ffffff;
            color: #2c3e50;
            font-weight: 500;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            min-height: 150px;
            resize: vertical;
        }

        .modern-textarea:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
        }

        .modern-textarea::placeholder {
            color: #95a5a6;
            font-weight: 400;
        }

        .modern-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: 10px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .modern-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
        }

        .modern-btn:active {
            transform: translateY(-1px);
        }

        .modern-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .modern-btn:hover::before {
            left: 100%;
        }

        .home-link {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #ecf0f1;
            text-align: center;
        }

        .home-link a {
            text-decoration: none;
            color: #667eea;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        .home-link a::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s ease;
        }

        .home-link a:hover {
            color: #764ba2;
        }

        .home-link a:hover::after {
            width: 100%;
        }

        .error-message {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #c0392b;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 15px;
            font-weight: 500;
            border-left: 4px solid #e74c3c;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.2);
            text-align: left;
        }

        .error-message i {
            margin-right: 10px;
            font-size: 18px;
        }

        .field-error {
            color: #e74c3c;
            font-size: 14px;
            font-weight: 500;
            margin-top: 8px;
            display: block;
            text-align: left;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 40px 0;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .info-card i {
            font-size: 24px;
            color: #667eea;
            margin-bottom: 15px;
        }

        .info-card h3 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-card p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .contact-info {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .contact-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .contact-header h1 {
                font-size: 28px;
            }
            
            .modern-input,
            .modern-textarea {
                padding: 14px 14px 14px 40px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="contact-container">
        <div class="logo-modern">
            <h1>Project Topic Checker</h1>
            <h2>Kano State Polytechnic</h2>
        </div>
        
        <div class="contact-header">
            <h1>Contact Us</h1>
            <p>Have questions? Get in touch with us</p>
        </div>
        
        <div class="contact-info">
            <div class="info-card">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Location</h3>
                <p>Kano State Polytechnic<br>Rimi GRA, Kano</p>
            </div>
            <div class="info-card">
                <i class="fas fa-phone"></i>
                <h3>Phone</h3>
                <p>+234 123 456 7890<br>Mon-Fri, 8:00-16:00</p>
            </div>
            <div class="info-card">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>info@ksp.edu.ng<br>support@ksp.edu.ng</p>
            </div>
        </div>
        
        <form class="contact" action="contact_process.php" method="post">
            <?php
                if(!empty($_SESSION['error'])) {
                    echo '<div class="error-message">';
                    echo '<i class="fas fa-exclamation-circle"></i>';
                    foreach($_SESSION['error'] as $er) {
                        echo $er . '<br>';
                    }
                    echo '</div>';
                    unset($_SESSION['error']);
                }
            ?>
            
            <div class="form-group">
                <label for="fnm">Full Name</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" id="fnm" name="fnm" class="modern-input" placeholder="Enter your full name" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['fnm'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['fnm'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="mno">Mobile Number</label>
                <div class="input-wrapper">
                    <i class="fas fa-mobile-alt"></i>
                    <input type="text" id="mno" name="mno" class="modern-input" placeholder="Enter your mobile number" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['mno'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['mno'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" class="modern-input" placeholder="Enter your email address" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['email'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['email'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="msg">Message</label>
                <div class="input-wrapper">
                    <i class="fas fa-comment"></i>
                    <textarea id="msg" name="msg" class="modern-textarea" placeholder="Enter your message" required></textarea>
                </div>
                <?php
                    if(isset($_SESSION['error']['msg'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['msg'].'</span>';
                    }
                ?>
            </div>
            
            <button type="submit" class="modern-btn">Send Message</button>
        </form>
        
        <div class="home-link">
            <a href="index.php">← Back to Home</a>
        </div>
    </div>
</body>
</html>
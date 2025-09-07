<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Topic Checker - Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Enhanced Modern Login Styles */
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
            overflow: hidden;
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

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            padding: 50px 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        .login-container::before {
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

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h1 {
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 700;
            position: relative;
        }

        .login-header h1::after {
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

        .login-header p {
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

        .links-container {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #ecf0f1;
        }

        .link-item {
            text-decoration: none;
            color: #667eea;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        .link-item::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s ease;
        }

        .link-item:hover {
            color: #764ba2;
        }

        .link-item:hover::after {
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

        .social-login {
            margin: 30px 0;
            position: relative;
        }

        .social-login p {
            position: relative;
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 25px;
        }

        .social-login p::before,
        .social-login p::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: #ecf0f1;
        }

        .social-login p::before {
            left: 0;
        }

        .social-login p::after {
            right: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #7f8c8d;
            font-size: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .admin-login-btn {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            margin-top: 20px;
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
        }

        .admin-login-btn:hover {
            box-shadow: 0 12px 30px rgba(39, 174, 96, 0.5);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .login-header h1 {
                font-size: 28px;
            }
            
            .links-container {
                flex-direction: column;
                gap: 15px;
                align-items: center;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="logo-modern">
            <h1>Project Topic Checker</h1>
            <h2>Kano State Polytechnic</h2>
        </div>
        
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Please login to your account</p>
        </div>
        
        <form class="login" action="login_process.php" method="post">
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
                <label for="unm">Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" id="unm" name="unm" class="modern-input" placeholder="Enter your username" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="pwd">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="pwd" name="pwd" class="modern-input" placeholder="Enter your password" required>
                </div>
            </div>
            
            <button type="submit" class="modern-btn">Login</button>
        </form>
        
        <div class="links-container">
            <a href="forget_password.php" class="link-item">Forgot Password?</a>
            <a href="register.php" class="link-item">Create Account</a>
        </div>
    </div>
</body>
</html>

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Topic Checker - Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Enhanced Modern Forgot Password Styles */
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

        .forgot-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            padding: 50px 40px;
            width: 100%;
            max-width: 550px;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .forgot-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        .forgot-container::before {
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

        .forgot-header {
            margin-bottom: 40px;
        }

        .forgot-header h1 {
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 700;
            position: relative;
        }

        .forgot-header h1::after {
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

        .forgot-header p {
            color: #7f8c8d;
            font-size: 18px;
            margin: 0;
            font-weight: 400;
        }

        .security-info {
            background: #e8f4f8;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .security-info h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .security-info p {
            color: #555;
            margin: 0;
            font-size: 15px;
            line-height: 1.5;
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

        .modern-select {
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
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237f8c8d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 18px;
        }

        .modern-select:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
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

        .login-link {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #ecf0f1;
            text-align: center;
        }

        .login-link a {
            text-decoration: none;
            color: #667eea;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .login-link a::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
        }

        .login-link a:hover::after {
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

        .password-requirements {
            background: #fff8e1;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }

        .password-requirements h4 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirements-list li {
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .requirements-list li:last-child {
            margin-bottom: 0;
        }

        .requirements-list li i {
            color: #f39c12;
        }

        @media (max-width: 480px) {
            .forgot-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .forgot-header h1 {
                font-size: 28px;
            }
            
            .modern-input,
            .modern-select {
                padding: 14px 14px 14px 40px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="forgot-container">
        <div class="logo-modern">
            <h1>Project Topic Checker</h1>
            <h2>Kano State Polytechnic</h2>
        </div>
        
        <div class="forgot-header">
            <h1>Forgot Password</h1>
            <p>Reset your password using your security question</p>
        </div>
        
        <div class="security-info">
            <h3><i class="fas fa-shield-alt"></i> Security Information</h3>
            <p>To protect your account, we require you to answer your security question to reset your password.</p>
        </div>
        
        <form class="login" action="forget_password_process.php" method="post">
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
                <?php
                    if(isset($_SESSION['error']['unm'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['unm'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="question">Security Question</label>
                <div class="input-wrapper">
                    <i class="fas fa-question-circle"></i>
                    <select name="question" id="question" class="modern-select" required>
                        <option value="">Select your security question</option>
                        <option value="Which is your Favourite Movie ?">Which is your Favourite Movie?</option>
                        <option value="Which is your Favourite Actress ?">What is your Favourite Actress?</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="answer">Security Answer</label>
                <div class="input-wrapper">
                    <i class="fas fa-key"></i>
                    <input type="text" id="answer" name="answer" class="modern-input" placeholder="Enter your security answer" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['answer'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['answer'].'</span>';
                    }
                ?>
            </div>
            
            <div class="password-requirements">
                <h4><i class="fas fa-info-circle"></i> Password Requirements</h4>
                <ul class="requirements-list">
                    <li><i class="fas fa-check-circle"></i> Minimum 8 characters long</li>
                    <li><i class="fas fa-check-circle"></i> Include at least one uppercase letter</li>
                    <li><i class="fas fa-check-circle"></i> Include at least one number</li>
                    <li><i class="fas fa-check-circle"></i> Include at least one special character</li>
                </ul>
            </div>
            
            <div class="form-group">
                <label for="pwd">New Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="pwd" name="pwd" class="modern-input" placeholder="Enter new password" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="cpwd">Confirm New Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="cpwd" name="cpwd" class="modern-input" placeholder="Confirm new password" required>
                </div>
            </div>
            
            <button type="submit" class="modern-btn">Reset Password</button>
        </form>
        
        <div class="login-link">
            <a href="login.php">
                <i class="fas fa-arrow-left"></i>
                Back to Login
            </a>
        </div>
    </div>
</body>
</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Topic Checker - Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Enhanced Modern Register Styles */
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

        .register-container {
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

        .register-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        .register-container::before {
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

        .register-header {
            margin-bottom: 40px;
        }

        .register-header h1 {
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 700;
            position: relative;
        }

        .register-header h1::after {
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

        .register-header p {
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

        .success-message {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #27ae60;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 16px;
            font-weight: 600;
            border-left: 4px solid #27ae60;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.2);
        }

        .success-message i {
            margin-right: 10px;
            font-size: 18px;
        }

        .terms {
            margin: 25px 0;
            text-align: left;
            font-size: 14px;
            color: #7f8c8d;
        }

        .terms input {
            margin-right: 8px;
        }

        .terms a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .register-header h1 {
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
    <div class="register-container">
        <div class="logo-modern">
            <h1>Project Topic Checker</h1>
            <h2>Kano State Polytechnic</h2>
        </div>
        
        <div class="register-header">
            <h1>Create Account</h1>
            <p>Fill in the form below to create your account</p>
        </div>
        
        <form class="register" action="register_process.php" method="post">
            <?php
                if(isset($_GET['register'])) {
                    echo '<div class="success-message">';
                    echo '<i class="fas fa-check-circle"></i>';
                    echo 'Registered Successfully!';
                    echo '</div>';
                }
                
                if(!empty($_SESSION['error'])) {
                    echo '<div class="error-message">';
                    echo '<i class="fas fa-exclamation-circle"></i>';
                    foreach($_SESSION['error'] as $key => $er) {
                        echo $er . '<br>';
                    }
                    echo '</div>';
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
                <label for="unm">Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-at"></i>
                    <input type="text" id="unm" name="unm" class="modern-input" placeholder="Choose a username" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['unm'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['unm'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="pwd">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="pwd" name="pwd" class="modern-input" placeholder="Create a password" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['pwd'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['pwd'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="cpwd">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="cpwd" name="cpwd" class="modern-input" placeholder="Confirm your password" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" class="modern-input" placeholder="Enter your email" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['email'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['email'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="cno">Contact Number</label>
                <div class="input-wrapper">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="cno" name="cno" class="modern-input" placeholder="Enter your phone number" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['cno'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['cno'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="question">Security Question</label>
                <div class="input-wrapper">
                    <i class="fas fa-question-circle"></i>
                    <select name="question" id="question" class="modern-select" required>
                        <option value="">Select a security question</option>
                        <option value="Which is your Favourite Movie ?">Which is your Favourite Movie ?</option>
                        <option value="Which is your Favourite Actress ?">Which is your Favourite Actress ?</option>
                    </select>
                </div>
                <?php
                    if(isset($_SESSION['error']['que'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['que'].'</span>';
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="answer">Security Answer</label>
                <div class="input-wrapper">
                    <i class="fas fa-key"></i>
                    <input type="text" id="answer" name="answer" class="modern-input" placeholder="Enter your answer" required>
                </div>
                <?php
                    if(isset($_SESSION['error']['answer'])) {
                        echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['answer'].'</span>';
                    }
                ?>
            </div>
            
            <div class="terms">
                <label>
                    <input type="checkbox" required>
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>
            
            <button type="submit" class="modern-btn">Create Account</button>
        </form>
        
        <div class="login-link">
            <a href="login.php">Already have an account? Login</a>
        </div>
        
        <?php
            unset($_SESSION['error']);
            unset($_GET['register']);
        ?>
    </div>
</body>
</html>
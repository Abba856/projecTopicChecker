<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Topic Checker - Register</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-y: auto;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 550px;
            overflow: hidden;
            max-height: 90vh;
            overflow-y: auto;
        }

        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        .register-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 1rem;
        }

        .register-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .register-form {
            padding: 30px 25px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            appearance: none;
        }

        .form-select:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .field-error {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 8px;
            display: block;
            text-align: left;
        }

        .field-error i {
            margin-right: 5px;
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #4caf50;
            display: flex;
            align-items: center;
        }

        .success-message i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .login-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .login-link a i {
            margin-right: 8px;
        }

        .terms {
            margin: 15px 0;
            text-align: left;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .terms input {
            margin-right: 8px;
        }

        .terms a {
            color: #3498db;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .back-to-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-to-home a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .back-to-home a:hover {
            text-decoration: underline;
        }

        .back-to-home a i {
            margin-right: 8px;
        }

        @media (max-width: 480px) {
            .register-container {
                border-radius: 15px;
            }
            
            .register-form {
                padding: 25px 20px;
            }
            
            .register-header {
                padding: 25px 15px;
            }
            
            .register-header h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="register-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Create Account</h1>
            <p>Fill in the form below to create your account</p>
        </div>
        
        <div class="register-form">
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
            
            <form action="register_process.php" method="post">
                <div class="form-group">
                    <label for="fnm">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="fnm" name="fnm" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    <?php
                        if(isset($_SESSION['error']['fnm'])) {
                            echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['fnm'].'</span>';
                        }
                    ?>
                </div>
                
                <div class="form-group">
                    <label for="unm">Registration Number</label>
                    <div class="input-with-icon">
                        <i class="fas fa-at input-icon"></i>
                        <input type="text" id="unm" name="unm" class="form-control" placeholder="Enter your Registration Number" required>
                    </div>
                    <?php
                        if(isset($_SESSION['error']['unm'])) {
                            echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['unm'].'</span>';
                        }
                    ?>
                </div>
                
                <div class="form-group">
                    <label for="pwd">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Create a password" required>
                    </div>
                    <?php
                        if(isset($_SESSION['error']['pwd'])) {
                            echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['pwd'].'</span>';
                        }
                    ?>
                </div>
                
                <div class="form-group">
                    <label for="cpwd">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="cpwd" name="cpwd" class="form-control" placeholder="Confirm your password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <?php
                        if(isset($_SESSION['error']['email'])) {
                            echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['email'].'</span>';
                        }
                    ?>
                </div>
                
                <div class="form-group">
                    <label for="cno">Contact Number</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" id="cno" name="cno" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                    <?php
                        if(isset($_SESSION['error']['cno'])) {
                            echo '<span class="field-error"><i class="fas fa-exclamation-circle"></i> '.$_SESSION['error']['cno'].'</span>';
                        }
                    ?>
                </div>
                
                <div class="form-group">
                    <label for="question">Security Question</label>
                    <div class="input-with-icon">
                        <i class="fas fa-question-circle input-icon"></i>
                        <select name="question" id="question" class="form-select" required>
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
                    <div class="input-with-icon">
                        <i class="fas fa-key input-icon"></i>
                        <input type="text" id="answer" name="answer" class="form-control" placeholder="Enter your answer" required>
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
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>
            
            <div class="login-link">
                <a href="login.php">
                    <i class="fas fa-sign-in-alt"></i> Already have an account? Login
                </a>
            </div>
            
            <div class="back-to-home">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
            
            <?php
                unset($_SESSION['error']);
                unset($_GET['register']);
            ?>
        </div>
    </div>
</body>
</html>
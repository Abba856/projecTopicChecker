<?php
    session_start();

    if(isset($_SESSION['admin']['status']))
    {
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Online Book Recommendation System</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-panel {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: none;
        }
        
        .panel-heading {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            text-align: center;
            padding: 20px;
        }
        
        .panel-title {
            font-size: 1.5em;
            font-weight: 600;
        }
        
        .login-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.3s ease;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .form-control {
            border-radius: 5px;
            padding: 20px 15px;
            border: 1px solid #ddd;
        }
        
        .error {
            color: #e74c3c;
            background-color: #fadbd8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: 500;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-lock fa-fw"></i> Admin Login
                        </h3>
                    </div>
                    <div class="panel-body">
                        <p class="text-center text-muted" style="margin-bottom: 20px;">
                            Sign in to access the admin panel
                        </p>
                        
                        <form role="form" action="login_process.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input class="form-control" placeholder="Username" name="unm" type="text" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-key"></i>
                                        </span>
                                        <input class="form-control" placeholder="Password" name="pwd" type="password" value="">
                                    </div>
                                </div>

                                <?php
                                    if(!empty($_SESSION['error']))
                                    {
                                        foreach($_SESSION['error'] as $er)
                                        {
                                            echo '<div class="error">'.$er.'</div>';
                                        }
                                        unset($_SESSION['error']);
                                    }
                                ?>
                        
                                <button type="submit" class="btn btn-lg btn-success btn-block login-btn">
                                    <i class="fa fa-sign-in fa-fw"></i> Sign In
                                </button>
                                
                                <div class="text-center" style="margin-top: 20px;">
                                    <a href="../index.php">
                                        <i class="fa fa-arrow-left"></i> Back to Website
                                    </a>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>

</body>

</html>

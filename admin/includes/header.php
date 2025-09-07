<?php 
    session_start();

    if(! isset($_SESSION['admin']['status']))
    {
        header("location:login.php");
    }
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Online Book Recommendation System - Admin Panel</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <style type="text/css">
        .error {
            color: red;
        }
        
        /* Enhanced sidebar styling */
        .navbar-static-side {
            background: #2c3e50;
        }
        
        .nav > li > a {
            color: #b4bcc2;
            transition: all 0.3s ease;
        }
        
        .nav > li > a:hover,
        .nav > li > a:focus {
            background: #34495e;
            color: #fff;
        }
        
        .nav > li.active > a {
            background: #3498db;
            color: #fff;
        }
        
        .nav-second-level li a {
            color: #95a5a6;
        }
        
        .nav-second-level li a:hover {
            color: #fff;
            background: #34495e;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #ecf0f1 !important;
        }
        
        .navbar-top-links .dropdown-user {
            min-width: 200px;
        }
        
        .sidebar-collapse .nav > li > a {
            padding: 12px 15px;
        }
        
        .sidebar-collapse .nav > li > a > i {
            margin-right: 10px;
        }
        
        .sidebar-collapse .nav .nav-second-level > li > a {
            padding: 10px 15px 10px 35px;
        }
        
        /* Arrow styling */
        .fa.arrow:before {
            content: "\f104";
        }
        
        .active > a > .fa.arrow:before {
            content: "\f107";
        }
    </style>

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Online Book Recommendation System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> 
                        <span class="hidden-xs"><?php echo $_SESSION['admin']['unm']; ?></span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> 
                                <?php echo $_SESSION['admin']['unm']; ?>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-tags fa-fw"></i> Category<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="category_add.php">Add Category</a>
                                </li>
                                <li>
                                    <a href="category_view.php">View Category</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-book fa-fw"></i> Book<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="book_add.php">Add Book</a>
                                </li>
                                <li>
                                    <a href="book_view.php">View Book</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-envelope fa-fw"></i> Contact<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="contact_view.php">View Contact</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="Users_view.php">View Users</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

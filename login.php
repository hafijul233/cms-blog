<?php

    session_reset();
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

// admin login code
if (isset($_POST["loginbutton"])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if (empty($email) || empty($password)) {
        
        $_SESSION["error"] = "All Fields are Required";
        $errortype = 'error';
        header("Location: login.php?type=" . $errortype);
    } 
    else {
        $sql = "SELECT `id`,`fullnames`, `username`, `profilepic` "
                . "FROM `userprofiles` "
                . "WHERE `emailaddress` = '$email' "
                . "AND `password` = '$password' "
                . "LIMIT 1;";

        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["fullname"] = $row["fullnames"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["profilepic"] = $row["profilepic"];
            
            $_SESSION["error"] = $row["username"]. ", Welcome Back !!!";
            $errortype = 'success';
            header("Location: dashboard.php?type=" . $errortype);
        }
        else {
            echo $conn->error;
            $_SESSION["error"] = "Invalid Email / Password.";
            $errortype = 'failed';
            header("Location: login.php?type=" . $errortype);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="resources/img/icon.png" type="image/png"/>
        <title>Blog's Login</title>
        <link href="resources/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="resources/css/adminstyle.css" rel="stylesheet" type="text/css"/>
        <script src="resources/jquery/jquery-3.2.1.js" ></script>
    </head>
    <body style="background-color: #ffffff;">
        <div class="wrapper">
            <div style="height:10px; background-color:#27aae1;" ></div>
            <nav class="navbar navbar-inverse"  >
                <div id="header-title" class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" aria-expanded="true" data-target="#collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand">
                        <img class="img-responsive" src="resources/img/headTitle.png" style="margin-top:-10px; width: 200px;" />
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="blog.php"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-question-sign"></span> About Us</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-gift"></span> Services</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-phone"></span> Contact Us</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-cutlery"></span> Features</a></li>
                    </ul>
                    <form action="search.php" method="post" class="navbar-form navbar-right">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" placeholder="Search..." >
                        </div>
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </div> 
            </nav>
            <div style="height:10px; background-color:#27aae1; margin-top: -20px;" ></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div style="height: 60px; width: 100%;" ></div>
                        <h2 class="text-center">Admin Panel Login</h2>
                        <div class="row">
                            <div class="col-sm-offset-4 col-sm-4">
                                <?php
                                message();
                                ?>
                                <form action="login.php" method="post">
                                    <div class="form-group">
                                        <label for="email"><span class="feild-info">Email:</span></label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-envelope text-primary"></span>
                                            </span>
                                            <input type="email" class="form-control" name="email" placeholder="Enter Email Address .." required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><span class="feild-info">Password:</span></label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-lock text-warning"></span>
                                            </span>
                                            <input type="password" class="form-control" name="password" placeholder="Enter Password .." required />
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="col-sm-12">
                                        <button type="submit" name="loginbutton" class="btn btn-success btn-lg btn-block">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div style="height: 70px; width: 100%;" ></div>
                    </div> 
                    <!-- Main Content -->
                </div>
            </div>
            <!-- Footer -->
            <div id="footer">
                <hr/>
                <p>
                    Theme By | Mohammad Hafijul Islam | &copy; 2018-2019 --- All rights reserved.
                </p>
                <a href="#" class="contact-link">Hafiz Softwares.Ltd.</a>
                <hr/>
            </div>
            <!-- / Footer -->
        </div>
        <script src="resources/bootstrap/js/bootstrap.min.js" ></script>
        <script src="resources/js/jquery.dataTables.min.js" ></script>
        <script src="resources/js/adminscript.js" ></script>
        <script >
            $(document).ready(function () {
                $('#adminTable').DataTable({
                    "lengthchange": true,
                    "seraching": false,
                    "paging": true,
                    "ordering": true
                });
            });
        </script>
    </body>
</html>

<?php
require_once 'utilities/session.php';
require_once 'utilities/message.php';
require_once 'utilities/validator.php';
require_once 'utilities/dbconnection.php';

//retrive All Inserted Categories
$sql = "SELECT `id`, `name`, `categorycreator`, `datetime`, `status` FROM categories WHERE `status` = 1;";
$result = $conn->query($sql);
$categorylist = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($categorylist, $row);
    }
} else {
    array_push($categorylist, NULL);
    echo $conn->error();
}

//$conn->close();
// category insert code
if (isset($_POST["submitbutton"])) {
    date_default_timezone_set("Asia/Dhaka");
    $currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());
    $categoryname = mysqli_real_escape_string($conn, $_POST["categoryname"]);
    $username = "Hafijul";
    $validationresult = categoryvaliadtor($categoryname);
    if ($validationresult != NULL) {
        $_SESSION["error"] = $validationresult;
        $errortype = 'error';
    } else {
        $sql = "INSERT INTO `categories`(`name`, `categorycreator`, `datetime`, `status`) "
                . "VALUES ('$categoryname','$username','$currentdatetime', 1);";
        if ($conn->query($sql) === TRUE) {
            $_SESSION["error"] = $categoryname . " is Added Successfully";
            $errortype = 'success';
            header("Location:category.php?type=" . $errortype);
        } else {
            $_SESSION["error"] = $categoryname . " is Added Failed";
            $errortype = 'failed';
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
        <title>Categories</title>
        <link href="resources/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="resources/css/adminstyle.css" rel="stylesheet" type="text/css"/>
        <script src="resources/jquery/jquery-3.2.1.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="wrapper">
            <div style="height:10px; background-color:#27aae1;" ></div>
            <nav class="navbar navbar-inverse" role="navigation" >
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
                        <li><a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
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
                        <button type="submit" class="btn btn-default" name="searchbutton"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </div> 
            </nav>
            <div style="height:10px; background-color:#27aae1; margin-top: -20px;" ></div>
            <div class="container-fluid">
                <div class="row">
                    <!-- Left slide bar -->
                    <div class="col-sm-2" id="slidebar">
                        <div class="row profile">
                            <div class="col-lg-12">
                                <center>
                                    <img class="img-circle profile-pic" src="postcontent/profile-pic/admin.jpg" />
                                </center>
                            </div>
                            <div class="col-lg-12">
                                <div class="profile-name">
                                    <p>Mohammad Hafijul Islam</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="#" method="get" class="sidebar-form">
                                    <div class="input-group">
                                        <input type="text" name="q" class="form-control" placeholder="Search...">
                                        <span class="input-group-btn">
                                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <ul id="side-menu" class="nav nav-pills nav-stacked">
                            <li ><a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
                            <li><a href="addnewpost.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
                            <li class="active"><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                            <li ><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin's</a></li>
                            <li ><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments</a></li>
                            <li ><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                            <li ><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                        </ul>
                    </div>
                    <!-- / Left slide bar -->

                    <div class="col-sm-10">
                        <h1>Manage Category</h1>
                        <div class="row">
                            <div class="col-sm-12">
<?php
message();
?>
                                <form action="category.php" method="post">
                                    <div class="form-group">
                                        <label for="categoryname"><span class="feild-info">Category Name:</span></label>
                                        <input type="text" class="form-control" name="categoryname" />
                                    </div>
                                    <div class="col-lg-offset-4 col-lg-4">
                                        <button type="submit" name="submitbutton" class="btn btn-success btn-lg btn-block">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <span class="panel-title">
                                            <p class="text-center text-capitalize"><span class="glyphicon glyphicon-tags"></span>  All Categories Table</p> 
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <table id="categoryTable" class="table table-striped table-hover display">
                                            <thead>
                                                <tr>
                                                    <th>ID Number</th>
                                                    <th>Category</th>
                                                    <th>User Created</th>
                                                    <th>Date Time</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
if (empty($categorylist)) {
    echo "<tr>";
    echo "<td colspan=4> There are no Category Found</td>";
    echo "</tr>";
} else {
    //`id`, `name`, `categorycreator`, `datetime`, `created`, `modified`, `status`
    foreach ($categorylist as $category) {
        echo "<tr>";

        echo "<td>" . $category['id'] . "</td>";
        echo "<td>" . $category['name'] . "</td>";
        echo "<td>" . $category['categorycreator'] . "</td>";
        echo "<td>" . str_replace("-", "/", $category['datetime']) . "</td>";

        if ($category['status'] == 1)
            echo "<td>" . "<label class=\"label label-success\">active</div>" . "</td>";

        else if ($category['status'] == 0)
            echo "<td>" . "<label class=\"label label-danger\">closed</div>" . "</td>";
        else
            echo "<td>" . "<label class=\"label label-warning\">unknown</div>" . "</td>";

        echo "</tr>";
    }
}
?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID Number</th>
                                                    <th>Category</th>
                                                    <th>User Created</th>
                                                    <th>Date Time</th>
                                                    <th>Status</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        <script type="text/javascript">
            $(document).ready(function () {
                $('#categoryTable').DataTable({
                    "lengthchange": true,
                    "seraching": false,
                    "paging": true,
                    "ordering": true
                });
            });
        </script>
        <script src="resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="resources/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="resources/js/adminscript.js" type="text/javascript"></script>
    </body>
</html>

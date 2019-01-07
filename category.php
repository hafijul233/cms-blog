
<?php
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

confirm_login();

//retrive All Existing Categories
$sql = "SELECT `id`, `name`, `categorycreator`, `datetime`, `status` FROM `categories`;";
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

// category insert code
if (isset($_POST["submitbutton"])) {
    date_default_timezone_set("Asia/Dhaka");
    $currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());
    $categoryname = mysqli_real_escape_string($conn, $_POST["categoryname"]);
    $username = $_SESSION['fullname'];
    $validationresult = categoryvaliadtor($categoryname);
    if ($validationresult != NULL) {
        $_SESSION["error"] = $validationresult;
        $errortype = 'error';
    } else {
        $sql = "INSERT INTO `categories`(`name`, `categorycreator`, `datetime`, `status`) "
                . "VALUES ('$categoryname','$username','$currentdatetime', 0);";
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

//Category Approve, Un Approve , Deleted Code
if (isset($_GET['id']) && isset($_GET['action'])) {
    $categoryid = $_GET['id'];
    $action = $_GET['action'];

    $sql = "UPDATE `categories` SET `status` = ";

    if ($action == "OK") {
        $sql .= "1 WHERE `id` = $categoryid;";
        $msg = "Category Approved";
    } else if ($action == "NOTOK") {
        $sql .= "0 WHERE `id` = $categoryid;";
        $msg = "Category Unapproved";
    } else if ($action == "DELETE") {
        $sql = "DELETE FROM `categories` WHERE `categories`.`id` = $categoryid;";
        $msg = "Category Deleted";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION["error"] = $msg;
        $errortype = 'success';
        header("Location: category.php?type=" . $errortype);
    } else {
        $_SESSION["error"] = "There was an error while proccessing";
        $errortype = 'failed';
        header("Location: category.php?type=" . $errortype);
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
        <script src="resources/jquery/jquery-3.2.1.js" ></script>
    </head>
    <body>
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
                                    <img class="img-circle profile-pic" src="postcontent/profile-pic/<?php echo $_SESSION['profilepic']; ?>" />
                                </center>
                            </div>
                            <div class="col-lg-12">
                                <div class="profile-name">
                                    <p class="text-center"><?php echo $_SESSION['fullname']; ?>
                                        <br>
                                        <span style="color: limegreen; font-size: 1em; font-weight: normal;"><?php  echo "@" . $_SESSION['username']; ?></span>
                                    </p>
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
                                                    <th>ID No</th>
                                                    <th class="text-center">Category</th>
                                                    <th>User Added</th>
                                                    <th class="text-center">Date Time</th>
                                                    <th>Status</th>
                                                    <th>Approve</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (empty($categorylist)) {
                                                    echo "<tr>";
                                                    echo "<td colspan=\"6\"> There are no Category Found</td>";
                                                    echo "</tr>";
                                                } else {
                                                    foreach ($categorylist as $category) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $category['id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $category['name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $category['categorycreator']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo str_replace("-", "/", $category['datetime']); ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($category['status'] == 1) {
                                                                    ?>
                                                                    <label class="btn btn-success">ON</label>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <label class="btn btn-default">OFF</label>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($category['status'] == 0) {
                                                                    ?>
                                                                    <a href="category.php?id=<?php echo $category['id'] . "&action=OK"; ?>"><button class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span></button></a>&nbsp;&nbsp;
                                                                    <?php
                                                                } if ($category['status'] == 1) {
                                                                    ?>
                                                                    <a href="category.php?id=<?php echo $category['id'] . "&action=NOTOK"; ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-sign"></span></button></a>
                                                                <?php }
                                                                ?>
                                                            </td>
                                                            <td>
                                                    <center>
                                                        <a href="category.php?id=<?php echo $category['id'] . "&action=EDIT"; ?>"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button></a>&nbsp;&nbsp;
                                                        <a href="category.php?id=<?php echo $category['id'] . "&action=DELETE"; ?>"><button class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span></button></a>
                                                    </center>
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
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
        <script src="resources/bootstrap/js/bootstrap.min.js" ></script>
        <script src="resources/js/jquery.dataTables.min.js" ></script>
        <script src="resources/js/adminscript.js" ></script>
        <script >
            $(document).ready(function () {
                $('#categoryTable').DataTable({
                    "lengthchange": true,
                    "seraching": false,
                    "paging": true,
                    "ordering": true
                });
            });
        </script>
    </body>
</html>

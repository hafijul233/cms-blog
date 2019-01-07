
<?php
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

confirm_login();

//retrive All Existing Categories
$sql = "SELECT `id`, `fullnames`, `username`, `emailaddress`, `createdby`, `datetime`, `status` FROM `userprofiles`;";
$result = $conn->query($sql);
$adminslist = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($adminslist, $row);
    }
} else {
    array_push($adminslist, NULL);
    echo $conn->error();
}

// admin insert code
if (isset($_POST["submitbutton"])) {
    date_default_timezone_set("Asia/Dhaka");
    $currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());

    $fullname = mysqli_real_escape_string($conn, $_POST['adminname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $adminname = $_SESSION['username'];

    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        print_r($_POST);
        die;
        $_SESSION["error"] = "All Fields are Required";
        $errortype = 'error';
        header("Location: manageadmin.php?type=" . $errortype);
    } else {
        //**************************************************************************
        //Image UPLOAD Code
        $target_dir = "postcontent/profile-pic/";
        $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extobj = new SplFileInfo(basename($_FILES["profilepic"]["name"]));
        $newname = $target_dir . md5(microtime()) . "." . $extobj->getExtension();
        $target_file = $newname;  //refer new name to uploaded file dir  
        $uploadOk = 1;
        if (file_exists($target_file)) {                                        // Check if file already exists
            $_SESSION["error"] = "Sorry, Image already exists.";
            $uploadOk = 0;
            $errortype = 'error';
            header("Location: manageadmin.php?type=" . $errortype);
        } else if ($_FILES["profilepic"]["size"] > 10485760) { //10MB max          // Check file size
            $_SESSION["error"] = "Sorry, your Image is too large.";
            $uploadOk = 0;
            $errortype = 'error';
            header("Location: manageadmin.php?type=" . $errortype);
        } else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { // Allow certain file formats
            $_SESSION["error"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            $errortype = 'error';
            header("Location: manageadmin.php?type=" . $errortype);
        } else if ($uploadOk == 0) {                                              // Check if $uploadOk is set to 0 by an error
            $_SESSION["error"] = "There is an Error occured. Please Notify Admininstration.";
            $errortype = 'error';
            header("Location: manageadmin.php?type=" . $errortype);
        } else {                                                                  // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
                $imageurl = basename($target_file);
                echo $imageurl;
                
                if ($imageurl != NULL) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            } else {
                $_SESSION["error"] = "Sorry, there was an error uploading your file.";
                $errortype = 'failed';
                header("Location: manageadmin.php?type=" . $errortype);
            }
        }
        //**************************************************************************

        if ($uploadOk == 1) {
            $sql = "INSERT INTO `userprofiles`(`fullnames`, `username`, `emailaddress`, `password`, `profilepic`, `createdby`, `datetime`, `status`)"
                    . "VALUES ('$fullname','$username','$email','$password','$imageurl','$adminname','$currentdatetime', 0);";
            if ($conn->query($sql) === TRUE) {
                $_SESSION["error"] = "New Admin Added Successfully";
                $errortype = 'success';
                header("Location: manageadmin.php?type=" . $errortype);
            } else {
                echo $conn->error;
                die;
                $_SESSION["error"] = "There was an error while posting";
                $errortype = 'failed';
                header("Location: manageadmin.php?type=" . $errortype);
            }
        }
        else {
            
        }
    }
}

//Admin Approve, Un Approve , Deleted Code
if (isset($_GET['id']) && isset($_GET['action'])) {
    $adminid = $_GET['id'];
    $action = $_GET['action'];

    $sql = "UPDATE `userprofiles` SET `status` = ";

    if ($action == "OK") {
        $sql .= "1 WHERE `id` = $adminid;";
        $msg = "Admin Approved";
    } else if ($action == "NOTOK") {
        $sql .= "0 WHERE `id` = $adminid;";
        $msg = "Admin Unapproved";
    } else if ($action == "DELETE") {
        $sql = "DELETE FROM `userprofiles` WHERE `userprofiles`.`id` = $adminid;";
        $msg = "Admin Deleted";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION["error"] = $msg;
        $errortype = 'success';
        header("Location: manageadmin.php?type=" . $errortype);
    } else {
        $_SESSION["error"] = "There was an error while proccessing";
        $errortype = 'failed';
        header("Location: manageadmin.php?type=" . $errortype);
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
        <title>Manage Admins</title>
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
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
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
                            <li><a href="manageadmin.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
                            <li><a href="manageadmin.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                            <li class="active"><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin's</a></li>
                            <li ><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments</a></li>
                            <li ><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                            <li ><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                        </ul>
                    </div>
                    <!-- / Left slide bar -->
                    <div class="col-sm-10">
                        <h1>Manage Admin Access</h1>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                message();
                                ?>
                                <form action="manageadmin.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="adminname"><span class="feild-info">Admin Fullname:</span></label>
                                        <input type="text" class="form-control" name="adminname" />
                                    </div>
                                    <div class="form-group">
                                        <label for="username"><span class="feild-info">Desired username:</span></label>
                                        <input type="text" class="form-control" name="username" />
                                    </div>
                                    <div class="form-group">
                                        <label for="profilepic"><span class="feild-info">Profile Picture:</span></label>
                                        <input type="file" class="form-control" name="profilepic" />
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><span class="feild-info">Email Address:</span></label>
                                        <input type="email" class="form-control" name="email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="passowrd"><span class="feild-info">Password:</span></label>
                                        <input type="text" id="txt1" class="form-control" name="password" />
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword"><span class="feild-info">Confirm Password:</span></label>
                                        <input type="text" id="txt2" class="form-control" name="confirm" />
                                    </div>

                                    <div class="col-lg-offset-4 col-lg-4">
                                        <button type="submit" name="submitbutton" class="btn btn-success btn-lg btn-block">Add New Admin</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <span class="panel-title">
                                            <p class="text-center text-capitalize"><span class="glyphicon glyphicon-tags"></span>  All Administration Control Table</p> 
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <table id="adminTable" class="table table-striped table-hover display">
                                            <thead>
                                                <tr>
                                                    <th>ID No</th>
                                                    <th class="text-center">Admin Name</th>
                                                    <th>User name</th>
                                                    <th>Added By</th>
                                                    <th class="text-center">Date Time</th>
                                                    <th>Status</th>
                                                    <th>Approve</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (empty($adminslist)) {
                                                    echo "<tr>";
                                                    echo "<td colspan=\"8\"> There are no Admin Found</td>";
                                                    echo "</tr>";
                                                } else {
                                                    $counter = 1;
                                                    foreach ($adminslist as $admin) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $counter++; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $admin['fullnames']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $admin['username']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $admin['createdby']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo str_replace("-", "/", $admin['datetime']); ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($admin['status'] == 1) {
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
                                                                if ($admin['status'] == 0) {
                                                                    ?>
                                                                    <a href="manageadmin.php?id=<?php echo $admin['id'] . "&action=OK"; ?>"><button class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span></button></a>&nbsp;&nbsp;
                                                                    <?php
                                                                } if ($admin['status'] == 1) {
                                                                    ?>
                                                                    <a href="manageadmin.php?id=<?php echo $admin['id'] . "&action=NOTOK"; ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-sign"></span></button></a>
                                                                <?php }
                                                                ?>
                                                            </td>
                                                            <td>
                                                    <center>
                                                        <a href="manageadmin.php?id=<?php echo $admin['id'] . "&action=EDIT"; ?>"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button></a>&nbsp;&nbsp;
                                                        <a href="manageadmin.php?id=<?php echo $admin['id'] . "&action=DELETE"; ?>"><button class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span></button></a>
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

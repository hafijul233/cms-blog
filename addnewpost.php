<?php
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

confirm_login();

//Retrive All Categories List on Form
$sql = "SELECT `id`, `name` FROM categories WHERE `status` = 1;";
$result = $conn->query($sql);
$categorylist = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($categorylist, $row);
    }
} else {
    echo $conn->error;
    array_push($categorylist, NULL);
}
//Insert Post call
if (isset($_POST["postentrybutton"])) {

    date_default_timezone_set("Asia/Dhaka");
    $currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());
    $posttitle = mysqli_real_escape_string($conn, $_POST["posttitle"]);
    $categorynumber = mysqli_real_escape_string($conn, $_POST["categoryno"]);
    $authorname = $_SESSION['fullname'];
    
    $postdescription = divremover($_POST["postdescription"]);
    
    $validationresult = titlevaliadtor($posttitle);
    
    if ($validationresult != NULL) {
        $_SESSION["error"] = $validationresult;
        $errortype = 'error';
        header("Location: addnewpost.php?type=" . $errortype);
    } else {
        //**************************************************************************
        //Image UPLOAD Code

        $target_dir = "postcontent/image/";
        $target_file = $target_dir . basename($_FILES["postimage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extobj = new SplFileInfo(basename($_FILES["postimage"]["name"]));
        $newname = $target_dir . md5(microtime()) . "." . $extobj->getExtension();
        $target_file = $newname;  //refer new name to uploaded file dir  
        $uploadOk = 1;
        if (file_exists($target_file)) {                                        // Check if file already exists
            $_SESSION["error"] = "Sorry, Image already exists.";
            $uploadOk = 0;
            $errortype = 'error';
            header("Location: addnewpost.php?type=" . $errortype);
        } else if ($_FILES["postimage"]["size"] > 10485760) { //10MB max          // Check file size
            $_SESSION["error"] = "Sorry, your Image is too large.";
            $uploadOk = 0;
            $errortype = 'error';
            header("Location: addnewpost.php?type=" . $errortype);
        } else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { // Allow certain file formats
            $_SESSION["error"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            $errortype = 'error';
            header("Location: addnewpost.php?type=" . $errortype);
        } else if ($uploadOk == 0) {                                              // Check if $uploadOk is set to 0 by an error
            $_SESSION["error"] = "There is an Error occured. Please Notify Admininstration.";
            $errortype = 'error';
            header("Location: addnewpost.php?type=" . $errortype);
        } else {                                                                  // if everything is ok, try to upload file
            if (move_uploaded_file($_FILES["postimage"]["tmp_name"], $target_file)) {
                
            } else {
                $_SESSION["error"] = "Sorry, there was an error uploading your file.";
                $errortype = 'failed';
                header("Location: addnewpost.php?type=" . $errortype);
            }
        }
        //**************************************************************************
        $imageurl = basename($target_file);

        $sql = "INSERT INTO `userposts`(`author`, `categoryno`, `datetime`, `title`, `image`, `post`, `status`) "
                . "VALUES ('$authorname','$categorynumber','$currentdatetime','$posttitle','$imageurl','$postdescription', 1);";
        if ($conn->query($sql) === TRUE) {
            $_SESSION["error"] = "Post Added Successfully";
            $errortype = 'success';
            header("Location: addnewpost.php?type=" . $errortype);
        } else {
            echo $conn->error;
            $_SESSION["error"] = "There was an error while posting";
            $errortype = 'failed';
            header("Location: addnewpost.php?type=" . $errortype);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="resources/img/icon.png" type="image/png"/>
        <title>Add New Post</title>
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css"/>
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
                        <li><a href="liveblog.php"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
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
                            <li class="active"><a href="addnewpost.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
                            <li ><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                            <li ><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin's</a></li>
                            <li ><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments</a></li>
                            <li ><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                            <li ><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                        </ul>
                    </div>
                    <!-- / Left slide bar -->
                    <!-- Main Content -->
                    <div class="col-sm-10">
                        <h1>Add New Post</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                message();
                                ?>
                                <form action="addnewpost.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="title"><span class="feild-info">Post Title:</span></label>
                                        <input type="text" class="form-control" name="posttitle" />
                                    </div>
                                    <div class="form-group">
                                        <label for="categoryname"><span class="feild-info">Category Name:</span></label>
                                        <select class="form-control" name="categoryno">
                                            <?php
                                            if (empty($categorylist)) {
                                                echo "<option value = \"N/A\"> There are no Category Found</option>";
                                            } else {
                                                foreach ($categorylist as $category) {
                                                    echo "<option value = \"" . $category["id"] . "\">" . $category["name"] . "</option>\n";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="post"><span class="feild-info">Post Description:</span></label>
                                        <textarea class="form-control textarea"  placeholder="Please Write something ....." name="postdescription" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image"><span class="feild-info">Image:</span></label>
                                        <input type="file" class="form-control" name="postimage" />
                                    </div>

                                    <div class="col-lg-offset-4 col-lg-4">
                                        <button type="submit" name="postentrybutton" class="btn btn-success btn-lg btn-block">Add Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div style="height: 20px; width: auto;"></div>
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
        <script src="resources/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" ></script>
        <script src="resources/js/adminscript.js" ></script>
        <script>
            $(function () {
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>
    </body>
</html>

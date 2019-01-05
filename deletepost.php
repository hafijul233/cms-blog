<?php
require_once 'utilities/session.php';
require_once 'utilities/dbconnection.php';

//Retrive Post to edit
if(isset($_GET["id"])) {
        $id = $_GET["id"];
        
    $sql = "SELECT `userposts`.`id`,`author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description` "
         . "FROM `userposts`, `categories` "
         . "WHERE `userposts`.`status` = 1 "
            . "AND `userposts`.`categoryno` = `categories`.`id` "
            . "AND `userposts`.`id` = $id ;";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $post = $row;
        }
    } else {

        $post = NULL;
    }
}

//DELETE Post call
if (isset($_POST['postdeletebutton'])) {
    $id = $_GET['id'];
    $postimage = $_GET['img'];
    //Image Delete Code
    $target_dir = "postcontent/image/";
    $target_file = $target_dir . $postimage;
    if (unlink($target_file) == TRUE) {
        $sql = "DELETE FROM `userposts` WHERE `id` = $id;";
        if ($conn->query($sql) === TRUE) {
            $_SESSION["error"] = "Post Deleted Successfully";
            $errortype = 'success';
            header("Location: dashboard.php?id=" . $id . "&type=" . $errortype);
        } else {
            $_SESSION["error"] = "There was an error while Deleting post from Database";
            $errortype = 'failed';
            header("Location: dashboard.php?id=" . $id . "&type=" . $errortype);
        }
    } else {
        $_SESSION["error"] = "There was an error while Deleting image";
        $errortype = 'failed';
        echo $target_file;
        die;
//header("Location: dashboard.php?id=" . $id . "&type=" . $errortype);
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
        <title>Delete Post</title>
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
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
                            <li class="active"><a href="editpost.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
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
                        <h1>Delete Post</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="<?php echo "deletepost.php?id=" . $post['id'] . "&img=" . $post['image']; ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="title"><span class="feild-info">Post Title:</span></label>
                                        <input type="text" class="form-control" name="posttitle" readonly value="<?php 
                                        if(empty($post['title'])){
                                            $post['title'] = NULL;
                                        }else {
                                            echo $post['title'];
                                        }?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="categoryname"><span class="feild-info">Category Name:</span></label>
                                        <input type="text" class="form-control" name="categoryname" readonly value="<?php 
                                        if(empty($post['categoryname'])){
                                            $post['categoryname'] = NULL;
                                        }else {
                                            echo $post['categoryname'];
                                        }?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="post"><span class="feild-info">Post Description:</span></label>
                                        <textarea class="form-control textarea"  placeholder="Please Write something ....." name="postdescription" readonly style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                            <?php 
                                            if(empty($post['description'])) {
                                                $post['description'] = NULL;
                                            }
                                            else {
                                                echo $post['description'];
                                            }
                                            ?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image"><span class="feild-info">Post Image:</span></label>
                                        <center>
                                            <img src="postcontent/image/<?php echo $post['image']; ?>" class="img-responsive img-thumbnail" style="height: 256px; width: auto;" >
                                        </center>
                                    </div>

                                    <div class="col-lg-offset-4 col-lg-4">
                                        <button type="submit" name="postdeletebutton" class="btn btn-danger btn-lg btn-block">Delete Post</button>
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

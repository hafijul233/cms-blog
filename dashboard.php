<?php
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

confirm_login();

$sql = "SELECT `userposts`.`id`,`author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description`, `userposts`.`status` "
        . "FROM `userposts`, `categories` "
        . "WHERE `userposts`.`status` = 1 "
        . "AND `userposts`.`categoryno` = `categories`.`id` "
        . "ORDER BY `userposts`.`id` DESC ;";

$result = $conn->query($sql);
$postslist = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        //sednig comments array one post array Comments
        array_push($postslist, $row);
    }
} else {

    array_push($postslist, NULL);

    echo $conn->error();
}

$sql = "SELECT COUNT(`id`) AS `disapproved` FROM `comments` WHERE `status` = 0;";

$result = $conn->query($sql);
$comments = NULL;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $comments = $row['disapproved'];
}
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="resources/img/icon.png" type="image/png"/>
        <title>Dashboard</title>
        <link href="resources/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="resources/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                    <form action="liveblog.php" method="get" class="navbar-form navbar-right">
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
                                    <img class="profile-pic" src="postcontent/profile-pic/<?php echo $_SESSION['profilepic']; ?>" />
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
                            <li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
                            <li ><a href="addnewpost.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
                            <li ><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                            <li ><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin's</a></li>
                            <li ><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments
                                    <?php if ($comments != NULL && $comments != 0) 
                                        echo "<label class=\"label label-warning pull-right\">" . $comments . "</label>";
                                    ?>
                                </a>
                            </li>
                            <li ><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                            <li ><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                        </ul>
                    </div>
                    <!-- / Left slide bar -->
                    <!-- Main Content -->
                    <div class="col-sm-10">
                        <h1>Admin Dashboard</h1>
                        <?php
                        message();
                        ?>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <span class="panel-title">
                                    <p class="text-center text-capitalize"><span class="glyphicon glyphicon-equalizer"></span>  Live Post Status Table</p> 
                                </span>
                            </div>
                            <div class="panel-body">
                                <table id="postTable" class="table table-bordered table-striped table-hover display">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Date & Time</th>
                                            <th>Author</th>
                                            <th>Categories</th>
                                            <th>Comments</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($postslist)) {
                                            echo "<tr>";
                                            echo "<td colspan=\"8\"> There are no Category Found</td>";
                                            echo "</tr>";
                                        } else {
                                            $counter = 1;
                                            foreach ($postslist as $post) {
                                                echo "<tr>";
                                                echo "<td>" . $counter . "</td>";
                                                echo "<td class=\"table-post-title\" title=\"" . $post['title'] . "\">";
                                                if (strlen($post['title']) > 20)
                                                    echo substr($post['title'], 0, 20) . " ...</td>";
                                                else
                                                    echo $post['title'];
                                                echo "</td>";
                                                echo "<td>" . str_replace("-", "/", $post['createtime']) . "</td>";
                                                echo "<td>" . $post['author'] . "</td>";
                                                echo "<td>";
                                                $categories = explode(" ", $post['categoryname']);
                                                foreach ($categories as $category) {
                                                    echo "<label class=\"label label-info\">" . $category . "</label>&nbsp";
                                                }
                                                echo "</td>";
                                                echo "<td>";
                                                $postid = $post['id'];
                                                $sql = "SELECT COUNT(CASE WHEN `status` = 1 THEN 1 END) AS `approved`, COUNT(CASE WHEN `status` = 0 THEN 1 END) AS `disapproved` "
                                                        . "FROM `comments` WHERE `postid` = $postid;";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    $status = $result->fetch_assoc();
                                                    $approved = $status['approved'];
                                                    $disapproved = $status['disapproved'];
                                                } else {
                                                    $approved = NULL;
                                                    $disapproved = NULL;
                                                }
                                                if (!empty($disapproved)) {
                                                    ?>
                                                <label class="label label-danger pull-left"><?php echo $disapproved; ?></label>
                                                <?php
                                            }
                                            if (!empty($approved)) {
                                                ?>
                                                <label class="label label-success pull-right"><?php echo $approved; ?></label>
                                                <?php
                                            }
                                            echo "</td>";
                                            if ($post['status'] == 1) {
                                                echo "<td><label class=\"btn btn-success\">ON</label></td>";
                                            } else {
                                                echo "<td><label class=\"btn btn-default\">OFF</label></td>";
                                            }
                                            ?>
                                            <td>
                                                <a href="editpost.php?id=<?php echo $post['id']; ?>"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button></a>&nbsp; &nbsp;
                                                <a href="deletepost.php?id=<?php echo $post['id']; ?>"><button class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span></button></a>
                                            </td>
                                            <td>
                                                <a href="detailpost.php?id=<?php echo $post['id']; ?>" target="_blank"><button class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button></a>
                                            </td>
                                            <?php
                                            echo "</tr>";

                                            $counter++;
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- / Main Content -->
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
                $('#postTable').DataTable();
            });
        </script>
    </body>
</html>

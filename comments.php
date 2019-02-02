<?php

    require_once 'utilities/RequiredUtilities.php';
    require_once 'utilities/dbconnection.php';

confirm_login();
    
    $sql = "SELECT `id`, `datetime` AS `commenttime`, `approvedby`, `name`, `comments`, `status`" .
           "FROM `comments` ".
           "ORDER BY `comments`.`id` DESC;";
    $result = $conn->query($sql);
    $commentslist = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($commentslist, $row);
        }
    } else {

        array_push($commentslist, NULL);

        echo $conn->error();
    }
    
    if(isset($_GET['commentid'])) {
        $commentid = $_GET['commentid'];
        $action = $_GET['action'];
        $adminname = $_SESSION['username'];
        
        $sql = "UPDATE `comments` SET `approvedby` = '$adminname',`status` = ";
        
        if($action == "OK") {
            $sql.= "1 WHERE `id` = $commentid;";
            $msg = "Comment Approved";
        }
        else if($action == "NOTOK") {
         $sql.= "0 WHERE `id` = $commentid;";   
            $msg = "Comment Unapproved";
        }
        else if($action == "DELETE") {
            $sql = "DELETE FROM `comments` WHERE `id` = $commentid;";
            $msg = "Comment Deleted";
        }
        if ($conn->query($sql) === TRUE) {
            $_SESSION["error"] = $msg;
            $errortype = 'success';
            header("Location: comments.php?type=" . $errortype);
        } else {
            $_SESSION["error"] = "There was an error while proccessing";
            $errortype = 'failed';
            header("Location: comments.php?type=" . $errortype);
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
        <title><?php if(empty($_SESSION['fullname']) == TRUE) {echo "COMMENTS | User's BLog"; }else { echo $_SESSION['fullname'] . " | COMMENTS"; } ?></title>
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="resources/dataTables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
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
                            <li><a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
                            <li ><a href="addnewpost.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
                            <li ><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                            <li ><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin's</a></li>
                            <li class="active"><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments</a></li>
                            <li ><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span> Live Blog</a></li>
                            <li ><a href="utilities/logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                        </ul>
                    </div>
                    <!-- / Left slide bar -->
                    <!-- Main Content -->
                    <div class="col-sm-10">
                        <h1>Manage Comments</h1>
                        <?php
                            message();
                        ?>
                        <br/>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <span class="panel-title">
                                    <p class="text-center text-capitalize"><span class="glyphicon glyphicon-comment"></span>  Live Comment Status Table</p> 
                                </span>
                            </div>
                            <div class="panel-body">
                              <table id="postTable" class="table table-striped table-hover display" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID No.</th>
                                            <th>Name</th>
                                            <th>Comments</th>
                                            <th>Date & Time</th>
                                            <th><center>Approved By</center></th>
                                            <th>Status</th>
                                            <th><center>Approve</center></th>
                                            <th><center>Action</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($commentslist)) {
                                            echo "<tr>";
                                            echo "<td colspan=\"8\"> There are no Comment Found</td>";
                                            echo "</tr>";
                                        } else {
                                            $counter = 1;
                                            foreach ($commentslist as $comment) {
                                              echo "<tr>";
                                                echo "<td>" . $counter . "</td>";
                                                echo "<td>" . $comment['name'] . "</td>";
                                                echo "<td title=\"" . $comment['comments'] ."\">"; 
                                                if(strlen($comment['comments'])>20)
                                                    echo substr($comment['comments'], 0, 20) . " ...</td>";
                                                else
                                                    echo $comment['comments'];
                                                echo "</td>";
                                                echo "<td>" . str_replace("-", "/", $comment['commenttime']) . "</td>";
                                                ?>
                                                <td>
                                                    <?php echo $comment['approvedby'];?>
                                                </td>
                                                <?php
                                                if($comment['status'] == 1){
                                                    echo "<td><label class=\"btn btn-warning\">ON</label></td>";
                                                }
                                                else {
                                                    echo "<td><label class=\"btn btn-default\">OFF</label></td>";
                                                }?>
                                                <td>
                                                    <?php if($comment['status'] == 0) { ?>
                                                    <a href="comments.php?commentid=<?php echo $comment['id']. "&action=OK";?>"><button class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span></button></a>&nbsp;&nbsp;
                                                    <?php } if($comment['status'] == 1) { ?>
                                                    <a href="comments.php?commentid=<?php echo $comment['id']. "&action=NOTOK";?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-sign"></span></button></a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="comments.php?commentid=<?php echo $comment['id']. "&action=DELETE";?>"><button class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button></a>&nbsp;&nbsp;
                                                    <a href="comments.php?commentid=<?php echo $comment['id']. "&action=DELETE";?>"><button class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span></button></a>
                                                    
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
                        <br/>
                    </div>
                    <!-- / Main Content -->
                </div>
                <!-- Delete Model -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-alert"></span>&nbsp;Warning Post Delete Confirmation</h3>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure to Delete this post with add it's belonging.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger">Delete Post</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Delete Model -->

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
        <script src="resources/dataTables/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="resources/dataTables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="resources/js/adminscript.js" ></script>
        <script >
            $(document).ready( function () {
                $('#postTable').DataTable();
            });
        </script>
    </body>
</html>

<?php

    require_once 'utilities/session.php';
    require_once 'utilities/message.php';
    require_once 'utilities/validator.php';
    require_once 'utilities/dbconnection.php';
    
    $sql = "SELECT `userposts`.`id`,`author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description`, `userposts`.`status` FROM `userposts`, `categories` WHERE `userposts`.`status` = 1 AND `userposts`.`categoryno` = `categories`.`id` ORDER BY `userposts`.`id` DESC ;";
    $result = $conn->query($sql);
    $postslist = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($postslist, $row);
        }
    } else {

        array_push($postslist, NULL);

        echo $conn->error();
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
                            <li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
                            <li ><a href="addnewpost.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
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
                                <table id="postTable" class="table table-striped table-hover display">
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
                                                echo "<td class=\"table-post-title\" title=\"" . $post['title'] ."\">"; 
                                                if(strlen($post['title'])>20)
                                                    echo substr($post['title'], 0, 20) . " ...</td>";
                                                else
                                                    echo $post['title'];
                                                echo "</td>";
                                                echo "<td>" . str_replace("-", "/", $post['createtime']) . "</td>";
                                                echo "<td>" . $post['author'] . "</td>";
                                                echo "<td>" ;
                                                        $categories = explode(" ", $post['categoryname']);
                                                        foreach ($categories as $category) {
                                                            echo "<label class=\"label label-info\">" . $category . "</label>&nbsp"; 
                                                        }
                                                echo "</td>";
                                                echo "<td>" . rand(1, 100) . "</td>";
                                                    if ($post['status'] == 1)
                                                        echo "<td>" . "<label class=\"label label-success\">active</div>" . "</td>";
                                                    else if ($post['status'] == 0)
                                                        echo "<td>" . "<label class=\"label label-danger\">closed</div>" . "</td>";
                                                    else
                                                        echo "<td>" . "<label class=\"label label-warning\">unknown</div>" . "</td>";
                                                ?>
                                                    <td>
                                                        <a href="editpost.php?id=<?php echo $post['id']; ?>"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button></a>&nbsp; &nbsp;
                                                        <a href="deletepost.php?id=<?php echo $post['id']; ?>"><button class="btn btn-danger" name="deletepost" id="deletepost" data-toggle="modal" data-target="#deleteModal" data-whe><span class="glyphicon glyphicon-erase"></span></button></a>
                                                    </td>
                                                    <td>
                                                        <a href="detailpost.php?id=<?php echo $post['id']; ?>" target="_blank"><button class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span></button></a>
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
        <script src="resources/js/jquery.dataTables.min.js" ></script>
        <script src="resources/js/adminscript.js" ></script>
        <script >
            $(document).ready( function () {
                $('#postTable').DataTable();
            });
        </script>
    </body>
</html>

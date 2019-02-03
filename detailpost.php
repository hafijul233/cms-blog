<?php
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

confirm_login();

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT `userposts`.`id`,`author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description` "
            . "FROM `userposts`, `categories` "
            . "WHERE `userposts`.`status` = 1 "
            . "AND `userposts`.`categoryno` = `categories`.`id` "
            . "AND `userposts`.`id` = $id;";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $post = $row;
    } else {
        $post = NULL;
    }
    $sql = "SELECT `name`, `comments`, `datetime` FROM `comments` "
            . "WHERE `status` = 1 "
            . "AND `postid` = $id;";

    $commentslist = array();

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($commentslist, $row);
        }
    } else {

        array_push($commentslist, NULL);
    }
}

//Insert Comments 
if (isset($_POST["commentbutton"])) {
    date_default_timezone_set("Asia/Dhaka");
    $currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $authorname = $_SESSION['fullname'];
    $admin = "Pending";
    $comment = divremover($_POST["comment"]);
    $postid = $_GET["id"];

    if (empty($email) || empty($name) || empty($comment)) {
        $_SESSION["error"] = "All Feilds Are Required";
        $errortype = 'error';
        header("Location: detailpost.php?type=" . $errortype . "&id=" . $postid);
    } else {

        $sql = "INSERT INTO `comments`(`postid`, `name`, `emailaddress`, `comments`, `datetime`, `approvedby`, `status`)" .
                "VALUES ($postid, '$name', '$email', '$comment', '$currentdatetime', '$admin', 0);";
        if ($conn->query($sql) === TRUE) {
            $_SESSION["error"] = "Comment Received Successfully. Waiting for admin Approveal.";
            $errortype = 'success';
            header("Location: detailpost.php?type=" . $errortype . "&id=" . $postid);
        } else {
            echo $conn->error;
            die;
            $_SESSION["error"] = "There was an error while commenting";
            $errortype = 'failed';
            header("Location: detailpost.php?type=" . $errortype . "&id=" . $postid);
        }
    }
}

//All category
$sql = "SELECT `name` "
        . "FROM `categories` "
        . "WHERE `categories`.`status` = 1 "
        . " ORDER BY `created` DESC ;";

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


if (isset($_GET['category'])) {
    $postslist = NULL;
    $sql = "SELECT `userposts`.`id`,`author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description` "
            . "FROM `userposts`, `categories` "
            . "WHERE `userposts`.`status` = 1 "
            . "AND `userposts`.`categoryno` = `categories`.`id` "
            . "AND `categories`.`name` = '$categoryname'"
            . "ORDER BY `userposts`.`created` DESC ;";

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
}
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?php if(empty($post['title']) == TRUE) {echo "User's BLog"; }else { echo $post['title'] . " | DETAIL"; } ?></title>
        <link rel="icon" href="resources/img/icon.png" type="image/png" />
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/css/publicstyle.css" rel="stylesheet" type="text/css"/>
        <script src="resources/jquery/jquery-3.2.1.js" ></script>
        <script src="resources/bootstrap/js/bootstrap.min.js" ></script>
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
                        <li class="active"><a href="liveblog.php"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
                        <li><a href="about.php"><span class="glyphicon glyphicon-question-sign"></span> About Us</a></li>
                        <li><a href="services.php"><span class="glyphicon glyphicon-gift"></span> Services</a></li>
                        <li><a href="contactus.php"><span class="glyphicon glyphicon-phone"></span> Contact Us</a></li>
                        <li><a href="features.php"><span class="glyphicon glyphicon-cutlery"></span> Features</a></li>
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
            <div class="container">
                <br/>
                <?php
                echo message();
                ?>
                <div class="blog-header">
                    <h1> Responsive CMS Blog</h1>
                    <p class="lead">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <?php
                        if (empty($post)) {
                            ?>
                            <div class="blogpost">
                                <h2 class="blogpost-title">Empty List</h2>
                                <p class="blogpost-description">There is no Post Entered... Please add new post <a href="#">Add ...</a></p>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="blogpost-detail thumbnail">
                                <div class="blogpost-header">
                                    <h1 class="blogpost-title">
                                        <?php echo htmlentities($post["title"]); ?>
                                    </h1>
                                    <p>
                                        <span class="glyphicon glyphicon-folder-open"></span>&nbsp;
                                        <label class="label label-info">
                                            <?php
                                            echo htmlentities($post["categoryname"]);
                                            $refcatgoryname = $post['categoryname'];
                                            ?>
                                        </label>,&nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-user"></span>&nbsp;
                                        <label class="text-info">
                                            <?php echo $post["author"]; ?>
                                        </label>,&nbsp;&nbsp;
                                        <span class="glyphicon glyphicon-time"></span>&nbsp; 
                                        <label>
                                            <?php echo date_format(date_create($post["createtime"]), "F d, Y"); ?>
                                        </label>
                                    </p>
                                </div>
                                <div class="blogpost-body">
                                    <img class="img img-responsive" src="<?php echo "postcontent/image/" . $post["image"]; ?>"/>
                                    <div class="caption">
                                        <div class="blogpost-description">
                                            <?php
                                            echo nl2br($post['description']);
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <span class="feild-info">Comments</span><br/><br/>
                                    <?php
                                    if (empty($commentslist) || empty($commentslist[0])) {
                                        
                                    } else {
                                        foreach ($commentslist as $comment) {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="comment-block">
                                                        <img style="margin: 10px ; width: 60px; height: 60px; border-radius: 50%;" class="pull-left" src="resources/img/user.png" />
                                                        <p style="margin-left: 90px;" class="comment-info"><?php echo $comment['name']; ?>
                                                            <span style="margin: -2px 10px 10px 90px;"class="description pull-right"><?php echo date_format(date_create($comment["datetime"]), "F d, Y h:i A"); ?></span>
                                                        </p>
                                                        <p style="margin-left: 90px;" class="comment"><?php echo nl2br($comment['comments']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <p class="lead feild-info" style="font-size: 1.5em; color: green;">Share your thought on this post</p>
                                    <form action="detailpost.php?id=<?php echo $post['id']; ?>" method="post">
                                        <div class="form-group">
                                            <label for="name"><span class="feild-info">Name:</span></label>
                                            <input type="text" class="form-control" name="name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="email"><span class="feild-info">Email:</span></label>
                                            <input type="email" class="form-control" name="email" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="comment"><span class="feild-info">Comment:</span></label>
                                            <textarea class="form-control"  placeholder="Please Write something ....." name="comment" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        </div>
                                        <div class="col-lg-offset-4 col-lg-4">
                                            <button type="submit" name="commentbutton" class="btn btn-primary btn-lg">Comment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-sm-offset-1 col-sm-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="blogpost-title text-center">About Me</h2>
                                <img class="img-responsive img-circle img-icon" src="postcontent/profile-pic/<?php echo $_SESSION['profilepic']; ?>" alt="<?php echo $_SESSION['fullname']; ?>"/>
                                <p class="blogpost-description">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                    ever since the 1500s, when an unknown printer took a galley of type
                                    and scrambled it to make a type specimen book. It has survived not
                                    only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s 
                                    with the release of Letraset sheets containing Lorem Ipsum passages,
                                    and more recently with desktop publishing software like Aldus 
                                    PageMaker including versions of Lorem Ipsum.<a href="#">Read More ...</a>
                                </p>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel panel-heading">
                                        <h2 class="panel-title text-center">
                                            <span class="glyphicon glyphicon-tags"></span>
                                            Categories
                                        </h2>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (!empty($categorylist)) { ?>
                                            <ul class="list-category"> 
                                                <?php
                                                $counter = 0;
                                                foreach ($categorylist as $category) {
                                                    $counter++;
                                                    ?>
                                                    <li class="list-category-item"><a href="liveblog.php?page=1&category=<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a></li>
                                                    <?php
                                                    if ($counter > 10)
                                                        break;
                                                }
                                                ?>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-success">
                                    <div class="panel panel-heading">
                                        <h2 class="panel-title text-center">
                                            <span class="glyphicon glyphicon-list-alt"></span>
                                            Related Posts
                                        </h2>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        //Preload Releted Post
                                        $sql = "SELECT `userposts`.`id`, `title` FROM `userposts`,`categories` WHERE `userposts`.`status` = 1 AND `categories`.`name` = '$refcatgoryname' ANd `userposts`.`categoryno` = `categories`.`id` ORDER BY `userposts`.`id` DESC ;";
                                        $result = $conn->query($sql);
                                        $reletedpostslist = array();
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                array_push($reletedpostslist, $row);
                                            }
                                        } else {
                                            array_push($reletedpostslist, NULL);

                                            echo $conn->error();
                                        }
                                        if (!empty($reletedpostslist)) {
                                            ?>
                                            <ul class="list-category"> 
                                                <?php
                                                $counter = 0;
                                                foreach ($reletedpostslist as $post) {
                                                    $counter++;
                                                    ?>
                                                    <li class="list-category-item">
                                                        <a href="detailpost.php?id=<?php echo $post['id']; ?>">
                                                            <?php
                                                            if (strlen($post['title']) > 25) {
                                                                echo substr($post['title'], 0, 22) . "...";
                                                            } else {
                                                                echo $post['title'];
                                                            }
                                                            ?></a>
                                                    </li>
                                                    <?php
                                                    if ($counter > 10)
                                                        break;
                                                }
                                                ?>
                                            </ul>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 20px; width: auto;"></div>
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
        <script src="resources/js/publicscript.js" ></script>
    </body>
</html>

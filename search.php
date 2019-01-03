<?php
    require_once 'utilities/session.php';
    require_once 'utilities/message.php';
    require_once 'utilities/validator.php';
    require_once 'utilities/dbconnection.php';
    
    if (isset($_POST["searchbutton"])) {
    if (!empty($_POST["search"])) {

        $search = $_POST["search"];
        $searchvalue = searchvaliadtor($search);
        $keywords = explode(" ", $searchvalue);

        $allResultpostlist = array();

        foreach ($keywords as $keyword) {
            $sql = "SELECT `datatable`.* FROM( " .
                    "SELECT `userposts`.`id`, `categories`.`name` as `categoryname`, `author`, `userposts`.`datetime` AS `posttime`, `title` AS `posttitle`, `post` AS `description`, `image`" .
                    " FROM `categories`,`userposts`" .
                    " WHERE `categories`.`id` = `userposts`.`categoryno`" .
                    " AND `userposts`.`status` = 1)AS `datatable`" .
                    " WHERE `categoryname` LIKE '%$keyword%'" .
                    " OR `author` LIKE '%$keyword%'" .
                    " OR `posttime` LIKE '%$keyword%'" .
                    " OR `posttitle` LIKE '%$keyword%'" .
                    " OR `description` LIKE '%$keyword%'" .
                    " ORDER BY `id` DESC;";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($allResultpostlist, $row);
                }
            } else {
                array_push($allResultpostlist, NULL);
            }
        }
    }

    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>User Blog's Page</title>
        <link rel="icon" href="resources/img/icon.png" type="image/png" />
        <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="resources/css/publicstyle.css" rel="stylesheet" type="text/css"/>
        <script src="resources/jquery/jquery-3.2.1.js" type="text/javascript"></script>
        <script src="resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
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
                <?php
                echo message();
                ?>
                <div class="blog-header">
                    <h1> Responsive CMS Blog</h1>
                    <p class="lead">
                        Showing Results for Search : <?php echo $searchvalue; ?>
                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <?php
                        if (empty($allResultpostlist) || $allResultpostlist[0]["id"] == NULL ) {
                            ?>
                            <div class="blogpost">
                                <h2 class="blogpost-title">Empty List</h2>
                                <p class="blogpost-description">There is no Post Entered... Please add new post <a href="#">Add ...</a></p>
                            </div>
                            <?php
                        } else {
                            foreach ($allResultpostlist as $post) {
                                ?>
                                <div class="blogpost thumbnail">
                                    <div class="blogpost-header">
                                        <h1 class="blogpost-title">
                                            <?php echo htmlentities($post["posttitle"]); ?>
                                        </h1>
                                        <p>
                                            Category:
                                            <label class="label label-info">
                                                <?php echo htmlentities($post["categoryname"]); ?>
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;Published on : 
                                                <?php echo date_format(date_create($post["posttime"]), "F d, Y"); ?>
                                        </p>
                                    </div>
                                    <div class="blogpost-body">
                                        <img class="img img-responsive" src="<?php echo "postcontent/image/" . $post["image"]; ?>" alt="<?php echo htmlentities($post["posttitle"]); ?>"/>
                                        <div class="caption">
                                            <div class="blogpost-description"><p>
                                                    <?php
                                                    $postdescription = str_replace("</p>", "", str_replace("<p>", "", $post["description"]));
                                                    if (strlen($postdescription) > 300) {
                                                        $postdescription = substr($postdescription, 0, 200) . " ... ";

                                                        echo $postdescription;
                                                    } else {
                                                        echo $postdescription;
                                                    }
                                                    ?>
                                                </p>
                                                <a class="pull-right" href="detailpost.php?id=<?php echo $post["id"]; ?>"><button class="btn btn-info">Read More &rsaquo;&rsaquo;</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                </div>
                <div class="col-sm-4">
                    <div class="post">
                        <h2 class="post-title">Test</h2>
                        <p class="post-description">
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
        <script src="resources/js/publicscript.js" type="text/javascript"></script>
    </body>
</html>

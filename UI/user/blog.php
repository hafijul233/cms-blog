<?php
include '../../utilities/session.php';
include '../../utilities/message.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Blog's Page</title>
        <link rel="icon" href="../../resources/img/icon.png" type="image/png" />
        <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="../../resources/css/publicstyle.css" rel="stylesheet" type="text/css"/>
        <script src="../../resources/jquery/jquery-3.2.1.js" type="text/javascript"></script>
        <script src="../../resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php 
        include 'include/header.php';
        ?>
        <div class="container">
            <div class="blog-header">
                <h1> Responsive CMS Blog</h1>
                <p class="lead">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </p>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?php
                            include '../../BLL/post/viewposts.php';
                        getpostlist();
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
        <?php
            include 'include/footer.php';
        ?>
        <script src="../../resources/js/publicscript.js" type="text/javascript"></script>
    </body>
</html>

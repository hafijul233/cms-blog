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
                            include '../../BLL/post/searchpost.php';
                    ?>
                        <p class="text-info">Search Results for:
                        <?php
                            echo $_GET["searchvalue"] . "</p><hr>";
                            $filename = "../../BLL/post/search/" . $_GET["searchvalue"] . ".json";
                            if(file_exists($filename))
                            {
                                $data = file_get_contents($filename);
                                $data = json_decode($data);
                                viewresultpost($data);
                            }
                    ?>
                </div>
            </div>
        </div>
        <?php
            include 'include/footer.php';
        ?>
        <script src="../../resources/js/publicscript.js" type="text/javascript"></script>
    </body>
</html>

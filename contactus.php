<?php
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

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
    <title><?php if(empty($_SESSION['fullname']) == TRUE) {echo "CCOCNTACT US | User's BLog"; }else { echo $_SESSION['fullname'] . " | CONTACT US"; } ?></title>
    <link rel="icon" href="resources/img/icon.png" type="image/png" />
    <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/publicstyle.css" rel="stylesheet" type="text/css"/>
    <script src="resources/jquery/jquery-3.2.1.js" ></script>
  </head>
  <body>
    <div class="wrapper">
      <div style="height:10px; background-color:#27aae1;" ></div>
      <nav class="navbar navbar-inverse header"  >
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
            <li><a href="liveblog.php"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
            <li><a href="about.php"><span class="glyphicon glyphicon-question-sign"></span> About Us</a></li>
            <li><a href="services.php"><span class="glyphicon glyphicon-gift"></span> Services</a></li>
            <li class="active"><a href="contactus.php"><span class="glyphicon glyphicon-phone"></span> Contact Us</a></li>
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
          <?php
          message();
          ?>
        <!-- Blog Header Container -->
        <div class="blog-header">
          <h1 class="text-capitalize"> Responsive CMS Blog</h1>
          <p class="lead">
              <?php
              if (empty($_GET['search']) == FALSE) {
                  echo "Showing Results For Search value: " . $_GET['search'];
              } else {
                  echo "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
              }
              ?>   
          </p>
        </div>
        <!-- /. Blog Header Container -->
        <!-- Main Content -->
        <div class="row">
          <div class="col-lg-8">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">About US</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-12">
                    <h2>What is Lorem Ipsum?</h2>
                    <p>
                      <strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.
                      Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                      printer took a galley of type and scrambled it to make a type specimen book. It has survived 
                      not only five centuries, but also the leap into electronic typesetting, remaining essentially
                      unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                      Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including
                      versions of Lorem Ipsum.
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <h2>Why do we use it?</h2>
                    <p>
                      It is a long established fact that a reader will be distracted by the readable content of a page when looking
                      at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, 
                      as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing 
                      packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                      uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident,
                      sometimes on purpose (injected humour and the like).
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <h2>Where does it come from?</h2>
                    <p>
                      It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                      The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here,
                      content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum
                      as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions
                      have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-offset-1 col-lg-3">
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
                              <li class="list-category-item"><a href="liveblog.php?category=<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a></li>
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
    </div>
    <!-- / Footer -->
    <script src="resources/js/publicscript.js" ></script>
    <script src="resources/bootstrap/js/bootstrap.min.js" ></script>
  </body>
</html>

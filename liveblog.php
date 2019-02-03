<?php
require_once 'utilities/RequiredUtilities.php';
require_once 'utilities/dbconnection.php';

//Total Post for Pagination 
$bloksizes = 5;
$sql = "SELECT count(`id`) AS `totalposts` FROM `userposts` WHERE `status` = 1";
$totalposts = selectarray($conn, $sql);
$totalposts = $totalposts[0]['totalposts'];

//All Post 
$postslist = array();
if (isset($_GET['searchbutton'])) {
    $search = $_GET['search'];
//Only SearchButton Press Empty Value
    if ($search == NULL || $search == ' ') {
        $postslist = NULL;
//Run Default Query

        $sql = " SELECT `userposts`.`id`, `author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description`"
                . " FROM `userposts`, `categories` "
                . " WHERE `userposts`.`status` = 1 "
                . " AND `userposts`.`categoryno` = `categories`.`id`"
                . " ORDER BY `userposts`.`id` DESC"
                . " LIMIT 0,$bloksizes";

        $postslist = selectarray($conn, $sql);
    }
//Search ButtonPressed with value
    else {
        $postslist = NULL;
        $searchvalues = searchvaliadtor($search);

        $keywords = explode(" ", $searchvalues);
        $resultCounter = 0;
        foreach ($keywords as $keyword) {
            $sql = "SELECT `datatable`.* FROM( "
                    . "SELECT `userposts`.`id`, `categories`.`name` AS `categoryname`, `author`, `userposts`.`datetime` AS `createtime`,`title`, `post` AS `description`, `image`"
                    . " FROM `categories`,`userposts`"
                    . " WHERE `categories`.`id` = `userposts`.`categoryno` AND `userposts`.`status` = 1)AS `datatable`"
                    . " WHERE  `categoryname` LIKE '%$keyword%'"
                    . " OR `author` LIKE '%$keyword%'"
                    . " OR `createtime` LIKE '%$keyword%'"
                    . " OR `title` LIKE '%$keyword%'"
                    . " OR `description` LIKE '%$keyword%'"
                    . " ORDER BY `id` DESC"
                    . " LIMIT 0,$bloksizes;";

            $temp = [];
            $temp = selectarray($conn, $sql);
            foreach ($temp as $post) {
                array_push($postslist, $post);
                $resultCounter++;
            }
        }
    }
}
//No Search Value with Page Number
else if (isset($_GET['page'])) {
    $postslist = NULL;
    $currentpage = $_GET['page'];
    
    if ($currentpage <= 1 || $currentpage == NULL) {// ?page=NUll / -neg / 0  show first 5 post
        $sql = "SELECT "
                . "`userposts`.`id`, `author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`,"
                . " `title`, `image`, `post` AS `description`"
                . " FROM `userposts`, `categories`"
                . " WHERE `userposts`.`status` = 1 "
                . " AND `userposts`.`categoryno` = `categories`.`id` "
                . " ORDER BY `userposts`.`id` DESC LIMIT 0,$bloksizes;";

        $postslist = selectarray($conn, $sql);
    } else {
        $postslist = NULL;
        $currentpost = ($currentpage * $bloksizes) - $bloksizes;
        
        if($totalposts - $currentpost < $bloksizes)
            $block = $totalposts - $currentpost;
        else 
            $block = $bloksizes;
        
        $sql = "SELECT "
                . "`userposts`.`id`, `author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`,"
                . " `title`, `image`, `post` AS `description`"
                . " FROM `userposts`, `categories`"
                . " WHERE `userposts`.`status` = 1 "
                . " AND `userposts`.`categoryno` = `categories`.`id` "
                . " ORDER BY `userposts`.`id` DESC LIMIT $currentpost,$block;";

        $postslist = selectarray($conn, $sql);
    }
}

//When user Just Visit Blog Page
else {
    $sql = " SELECT `userposts`.`id`, `author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description`"
            . " FROM `userposts`, `categories` "
            . " WHERE `userposts`.`status` = 1 "
            . " AND `userposts`.`categoryno` = `categories`.`id`"
            . " ORDER BY `userposts`.`id` DESC"
            . " LIMIT 0,5";

    $postslist = selectarray($conn, $sql);
}

//All category
$sql = "SELECT `name` "
        . "FROM `categories` "
        . "WHERE `categories`.`status` = 1 "
        . " ORDER BY `created` DESC ;";
$categorylist = selectarray($conn, $sql);

//Total Post for Pagination 
$sql = "SELECT count(`id`) AS `totalposts` FROM `userposts` WHERE `status` = 1";
$totalposts = selectarray($conn, $sql);
$totalposts = $totalposts[0]['totalposts'];
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>User Blog's Page</title>
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
            <li class="active"><a href="liveblog.php"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
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
              <?php
              if (empty($postslist) == TRUE) { // if There is Not Post To Show
                  ?>
                <div class="blogpost thumbnail">
                  <div class="blogpost-header">
                    <h2 class="blogpost-title">Empty List</h2>
                  </div>
                  <div class="blogpost-body">
                    <div class="blogpost-description">
                      There is no Post to Show... Please add new post 
                      <a href="addnewpost.php" class="lead">Add One ...</a>
                    </div>
                  </div>
                </div>
                <?php
            } else { // There a post that can be display
                ?>
                <?php
                foreach ($postslist as $post) {
                    if (!empty($post)) {
                        ?>
                        <div class="blogpost thumbnail">
                          <div class="blogpost-header">
                            <h1 class="blogpost-title">
                                <?php echo htmlentities($post["title"]); ?>
                            </h1>
                            <p class="text-justify">
                              <span class="glyphicon glyphicon-folder-open"></span>&nbsp;
                              <label class="label label-info">
                                  <?php echo htmlentities($post["categoryname"]); ?>
                              </label>,&nbsp;&nbsp;
                              <span class="glyphicon glyphicon-user"></span>&nbsp;
                              <label class="text-info">
                                  <?php echo $post["author"]; ?>
                              </label>,&nbsp;&nbsp;
                              <span class="glyphicon glyphicon-time"></span>&nbsp; 
                              <label  class="text-info">
                                  <?php echo date_format(date_create($post["createtime"]), "F d, Y"); ?>
                              </label>
                            </p>
                          </div><!-- /. Blog header -->
                          <div class="blogpost-body">
                            <div class="blogpost-description">
                              <img class="img img-responsive" src="<?php echo "postcontent/image/" . $post["image"]; ?>" alt="<?php echo $post["image"]; ?>"/>
                              <!-- /. Post title Image -->
                              <div class="caption"> <!-- caption -->
                                <div class="blogpost-description">
                                    <?php
                                    $postdescription = str_replace("</p>", "", str_replace("<p>", "", $post["description"]));
                                    if (strlen($postdescription) > 300)
                                        echo substr($postdescription, 0, 300) . " ...";
                                    else
                                        echo $postdescription;
                                    ?>
                                  <p><a href="detailpost.php?id=<?php echo$post['id']; ?>" class="btn btn-info pull-right">Read More ...</a></p>
                                </div>
                              </div><!-- /.caption -->
                            </div>
                          </div><!-- /. Blog-post Body -->
                        </div><!-- /. Blog-post Thumbnail -->
                        <?php
                    }//if $post is not empty
                }// foreach loop closing 
                ?>
                <center>
                  <nav class="">
                    <ul class="pagination pagination-lg">
                        <?php
                        if (isset($currentpage)) {
                            if ($currentpage > 1) {
                                ?>
                              <li><a href="liveblog.php?page=<?php echo $currentpage - 1; ?>">&laquo;</a></li>
                              <?php
                          }
                      }

                      for ($i = 1; $i <ceil($totalposts / 5); $i++) {
                          if ($currentpage == $i) {
                              ?>
                              <li class="active"><a href="liveblog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                              <?php
                          } else {
                              ?>
                              <li><a href="liveblog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                              <?php
                          }
                      }
                      if (isset($currentpage)) {
                          if ($currentpage < ceil($totalposts / 5)-1) {
                              ?>
                              <li><a href="liveblog.php?page=<?php echo $currentpage + 1; ?>">&raquo;</a></li>
                              <?php
                          }
                      }
                      ?>
                    </ul>
                  </nav>
                </center>
            <?php } ?>
          </div>
          <div class="col-lg-offset-1 col-lg-3">
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
                              <li class="list-category-item">
                                <a href="liveblog.php?page=1&category=<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
                              </li>
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
            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-success">
                  <div class="panel panel-heading">
                    <h2 class="panel-title text-center">
                      <span class="glyphicon glyphicon-list-alt"></span>
                      Recent Posts
                    </h2>
                  </div>
                  <div class="panel-body">
                      <?php if (!empty($postslist)) { ?>
                        <ul class="list-category"> 
                            <?php
                            $counter = 0;
                            foreach ($postslist as $post) {
                                $counter++;
                                ?>
                              <li class="list-category-item">
                                <a href="detailpost.php?id=<?php echo $post['id']; ?>">
                                    <?php
                                    if (strlen($post['title']) > 25)
                                        echo substr($post['title'], 0, 22) . "...";
                                    else
                                        echo $post['title'];
                                    ?>
                                </a>
                              </li>
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
    <script src="resources/bootstrap/js/bootstrap.min.js" ></script>
  </body>
</html>

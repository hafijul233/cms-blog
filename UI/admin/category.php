<?php
    include '../../utilities/session.php';
    include '../../utilities/message.php';
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../resources/img/icon.png" type="image/png"/>
    <title>Categories</title>
    <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="../../resources/css/adminstyle.css" rel="stylesheet" type="text/css"/>
    <script src="../../resources/jquery/jquery-1.9.1.js" type="text/javascript"></script>
  </head>
  <body>
      <div class="container-fluid">
          <div class="row">
              <div class="col-sm-2">
                  <h3>Admin Panel</h3>
                  <ul id="side-menu" class="nav nav-pills nav-stacked">
                      <li><a href="dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
                      <li><a href="addnewpost.php"><span class="glyphicon glyphicon-list"></span> Add New Post</a></li>
                      <li class="active"><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Categories</a></li>
                      <li><a href="manageadmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
                      <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments</a></li>
                      <li><a href="liveblog.php"><span class="glyphicon glyphicon-equalizer"></span> Live Blog's</a></li>
                      <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                  </ul>
              </div><!-- Side Area -->
              <div class="col-sm-10">
                <section>
                  <h1>Manage Category</h1>
                  <div class="row">
                      <div class="col-sm-12">
                          <?php
                            echo message();
                          ?>
                          <form action="../../BLL/category/addcategory.php" method="post">
                              <div class="form-group">
                                  <label for="categoryname">Name:</label>
                                  <input type="text" class="form-control" name="categoryname" />
                              </div>
                              <button type="submit" class="btn btn-success btn-lg pull-right">Submit</button> 
                          </form>
                      </div>
                  </div>
                  <br/>
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="panel panel-info">
                              <div class="panel-title">
                                  <h3 class="text-center">
                                      <span class="glyphicon glyphicon-tags"></span>  All Categories Table 
                                  </h3>
                              </div>
                              <div class="panel-body">
                                  <table class="table table-bordered table-striped table-hover">
                                      <thead>
                                          <tr>
                                              <th>ID Number</th>
                                              <th>Category</th>
                                              <th>User Created</th>
                                              <th>Date Time</th>
                                              <th>Status</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                                include '../../BLL/category/listcategory.php';
                                                
                                                getcategorylist();
                                          ?>
                                      </tbody>
                                      <tfoot>
                                          <tr>
                                              <th>ID Number</th>
                                              <th>Category</th>
                                              <th>User Created</th>
                                              <th>Date Time</th>
                                              <th>Status</th>
                                          </tr>
                                      </tfoot>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                </section>
              </div> <!-- Main Content -->
            </div><!-- main row -->
        </div>
      <?php
        include 'include/footer.php';
      ?>
    <script src="../../resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>

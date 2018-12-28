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
    <link href="../../resources/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="../../resources/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../resources/css/adminstyle.css" rel="stylesheet" type="text/css"/>
    <script src="../../resources/jquery/jquery-3.2.1.js" type="text/javascript"></script>
  </head>
  <body>
      <div class="container-fluid">
          <div class="row">
              <?php include 'include/slidebar.php'; ?>
              <!-- Side Area -->
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
                                  <label for="categoryname"><span class="feild-info">Category Name:</span></label>
                                  <input type="text" class="form-control" name="categoryname" />
                              </div>
                              <div class="col-lg-offset-4 col-lg-4">
                                  <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                              </div>
                          </form>
                      </div>
                  </div>
                  <br/>
                  <br/>
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="panel panel-info">
                              <div class="panel-heading">
                                  <span class="panel-title">
                                      <p class="text-center text-capitalize"><span class="glyphicon glyphicon-tags"></span>  All Categories Table</p> 
                                  </span>
                              </div>
                              <div class="panel-body">
                                  <table id="categoryTable" class="table table-striped table-hover display">
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
    <script src="../../resources/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../../resources/js/adminscript.js" type="text/javascript"></script>
       <script type="text/javascript">
          $(document).ready( function () {
            $('#categoryTable').DataTable({
                "lengthchange" : true,
                "seraching" : false,
                "paging" : true,
                "ordering" : true
            } );
          } );
      </script>
  </body>
</html>

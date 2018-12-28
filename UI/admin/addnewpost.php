<?php
    include '../../utilities/session.php';
    include '../../utilities/message.php';
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="../../resources/img/icon.png" type="image/png"/>
    <title>Add New Post</title>
    <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../resources/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="../../resources/css/adminstyle.css" rel="stylesheet" type="text/css"/>
    <link href="../../resources/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css"/>
    <script src="../../resources/jquery/jquery-3.2.1.js" type="text/javascript"></script>
  </head>
  <body>
      <div class="container-fluid">
          <div class="row">
              <?php include 'include/slidebar.php'; ?>
              <!-- Side Area -->
              <div class="col-sm-10">
                <section>
                  <h1>Add New Post</h1>
                    <div class="row">
                      <div class="col-lg-12">
                          <?php
                            echo message();
                          ?>
                          <form action="../../BLL/post/addpost.php" method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                  <label for="title"><span class="feild-info">Post Title:</span></label>
                                  <input type="text" class="form-control" name="posttitle" />
                              </div>
                              <div class="form-group">
                                  <label for="categoryname"><span class="feild-info">Category Name:</span></label>
                                  <select class="form-control" name="categoryno">
                                      <?php
                                            include '../../BLL/post/categoryselector.php';
                                                
                                            getcategoryoptions();
                                      ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="post"><span class="feild-info">Post Description:</span></label>
                                  <textarea class="form-control textarea"  placeholder="Please Write something ....." name="postdescription" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                              </div>
                              <div class="form-group">
                                  <label for="image"><span class="feild-info">Image:</span></label>
                                  <input type="file" class="form-control" name="postimage" />
                              </div>
                              
                              <div class="col-lg-offset-4 col-lg-4">
                                  <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                              </div>
                          </form>
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
    <script src="../../resources/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <script src="../../resources/js/adminscript.js" type="text/javascript"></script>
    <script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
  </body>
</html>

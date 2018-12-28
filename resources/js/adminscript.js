jQuery(document).ready(function($){
  // Get current path and find target link
  var path = window.location.pathname.split("/").pop();
  
  // Account for home page with empty path
  switch ( path ) {
      case 'addnewpost.php' : path = 'addnewpost.php';
          break;
      
      case 'allposts.php' : path = 'allposts.php';
          break;
      
      case 'category.php' : path = 'category.php';
          break;
      
      case 'comments.php' : path = 'comments.php';
          break;
      
      case 'dashboard.php' : path = 'dashboard.php';
          break;
      
      case 'liveblog.php' : path = 'liveblog.php';
          break;
      
      case 'manageadmin.php' : path = 'manageadmin.php';
          break;
      
       deafult : path = 'dashboard.php';
  }
      
  var target = $('#side-menu a[href="'+path+'"]');
  // Add active class to target link
  target.addClass('active');
});
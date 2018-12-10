<?php
   include '../../utilities/session.php';
   include '../../DAL/category/insertcategory.php'; 
   include '../../DAL/dbconnection.php'; 
   
   date_default_timezone_set("Asia/Dhaka");
    
    $currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());
    
    $categoryname = mysqli_real_escape_string($conn, $_POST["categoryname"]);

    $username = "Hafijul";
    
    echo $categoryname . "-> Time: " . $currentdatetime;
    
    if(empty($categoryname) || empty($username) || empty($currentdatetime)) {
        
        $_SESSION["error"] = "Category Name is Empty";
        
        $errortype = 'error';
    }
    
    elseif (strlen($categoryname) > 100) {
        
        $_SESSION["error"] = "Category Name is too Large. Acceptable Size(3 to 100)";
        
        $errortype = 'error';
    }
    
    elseif (strlen($categoryname) < 3) {
        
        $_SESSION["error"] = "Category Name is too Small. Acceptable Size(3 to 100)";
        
        $errortype = 'error';
    }
    
    else {
        $statue = insertcategory($categoryname, $username, $currentdatetime);

        if($statue == 1) {
            
            $_SESSION["error"] = $categoryname . " is Added Successfully";
        
            $errortype = 'success';
        }
        
        else {
            
            $_SESSION["error"] = $categoryname . " is Added Failed";
            
            $errortype = 'failed';
        }
    }
    
    header("Location: ../../UI/admin/category.php?type=" . $errortype);
    


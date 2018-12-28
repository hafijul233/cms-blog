<?php
   include '../../utilities/session.php';
   include '../../utilities/validator.php'; 
   include '../../DAL/category/insertcategory.php'; 
   include '../../DAL/dbconnection.php'; 
   
   date_default_timezone_set("Asia/Dhaka");
    
    $currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());
    
    $categoryname = mysqli_real_escape_string($conn, $_POST["categoryname"]);

    $username = "Hafijul";
    
    $validationresult = categoryvaliadtor($categoryname);
    
    if($validationresult != NULL) {
        
        $_SESSION["error"] = $validationresult;
        
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
    


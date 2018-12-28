<?php

include '../../utilities/session.php';
include '../../utilities/validator.php';
include '../../DAL/post/insertpost.php';
include '../../DAL/dbconnection.php';

date_default_timezone_set("Asia/Dhaka");

$currentdatetime = strftime("%d-%m-%Y %H:%M:%S", time());

$posttitle = mysqli_real_escape_string($conn, $_POST["posttitle"]);

$categorynumber = mysqli_real_escape_string($conn, $_POST["categoryno"]);

$authorname = "Hafijul";

$postdescription = $_POST["postdescription"];

$validationresult = titlevaliadtor($posttitle);

if ($validationresult != NULL) {

    $_SESSION["error"] = $validationresult;

    $errortype = 'error';

    header("Location: ../../UI/admin/addnewpost.php?type=" . $errortype);
} 

else {

    //**************************************************************************
    //Image UPLOAD Code

    $target_dir = "../../postcontent/image/";
    
    $target_file = $target_dir . basename($_FILES["postimage"]["name"]);
    
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    $extobj = new SplFileInfo(basename($_FILES["postimage"]["name"]));
            
    $newname = $target_dir . md5(microtime()) . "." . $extobj->getExtension();
    
    $target_file = $newname;  //refer new name to uploaded file dir  
    
    $uploadOk = 1;
    
        if (file_exists($target_file)) {                                        // Check if file already exists
        
            $_SESSION["error"] =  "Sorry, Image already exists.";
        
            $uploadOk = 0;
            
            $errortype = 'error';
            
            header("Location: ../../UI/admin/addnewpost.php?type=" . $errortype);
        
        }
        
        else if ($_FILES["postimage"]["size"] > 10485760) { //10MB max          // Check file size
        
            $_SESSION["error"] =  "Sorry, your Image is too large.";
        
            $uploadOk = 0;
            
            $errortype = 'error';
            
            header("Location: ../../UI/admin/addnewpost.php?type=" . $errortype);
            
        }
    
        else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { // Allow certain file formats
        
            $_SESSION["error"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        
            $uploadOk = 0;
            
            $errortype = 'error';
            
            header("Location: ../../UI/admin/addnewpost.php?type=" . $errortype);
            
        }
    
        else if ($uploadOk == 0) {                                              // Check if $uploadOk is set to 0 by an error
        
            $_SESSION["error"] =  "There is an Error occured. Please Notify Admininstration.";
        
            $errortype = 'error';
            
            header("Location: ../../UI/admin/addnewpost.php?type=" . $errortype);
            
        
        }
        
        else {                                                                  // if everything is ok, try to upload file
                        
            if (move_uploaded_file($_FILES["postimage"]["tmp_name"], $target_file)) {
            
        }
        
        else {
            $_SESSION["error"] = "Sorry, there was an error uploading your file.";
            
            $errortype = 'failed';
            
            header("Location: ../../UI/admin/addnewpost.php?type=" . $errortype);
        }
    }

    //**************************************************************************


    $statue = insertcategory($authorname, $categorynumber, $posttitle, $currentdatetime, $postdescription, basename($target_file));

    if ($statue == 1) {

        $_SESSION["error"] = "Post Added Successfully";

        $errortype = 'success';
    }
    
    else {

        $_SESSION["error"] = "There was an error while posting";

        $errortype = 'failed';
    }
}

header("Location: ../../UI/admin/addnewpost.php?type=" . $errortype);


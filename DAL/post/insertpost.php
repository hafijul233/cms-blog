<?php
    function insertcategory($authorname, $categorynumber, $posttitle, $currentdatetime, $postdescription, $imageurl)
    {
        include '../../DAL/dbconnection.php';
        
        $sql = "INSERT INTO `userposts`(`author`, `categoryno`, `datetime`, `title`, `image`, `post`, `status`) "
             . "VALUES ('$authorname','$categorynumber','$currentdatetime','$posttitle','$imageurl','$postdescription', 1);";

            if ($conn->query($sql) === TRUE) {
                $result = 1;
            } 
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                $result = 0;
            }

        $conn->close();
    
       return $result;
    }
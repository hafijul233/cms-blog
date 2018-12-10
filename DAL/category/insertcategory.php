<?php
        
    function insertcategory($categoryname, $user = 'N/A', $datetime) {
        
        include '../../DAL/dbconnection.php';
        
        $sql = "INSERT INTO `categories`(`name`, `categorycreator`, `datetime`, `status`) "
             . "VALUES ('$categoryname','$user','$datetime', 1);";

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
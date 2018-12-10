<?php

    function retrivecategory() {
        
        $categorylist = array();
        
        include '../../DAL/dbconnection.php';
        
        //`id`, `name`, `categorycreator`, `datetime`, `created`, `modified`, `status`
        $sql = "SELECT `id`, `name`, `categorycreator`,`datetime`, `status` FROM categories WHERE `status` = 1;";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                //print_r($row);
                array_push($categorylist,$row);
            }
            
        }
        else {
            
            array_push($categorylist, NULL);
            
            echo $conn->error();
            die;
        }
        
        $conn->close();
        
        return $categorylist;
    }
<?php

function retriveallposts() {
    
    $postslist = array();
    
    include '../../DAL/dbconnection.php';

    $sql = "SELECT `userposts`.`id`,`author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description` FROM `userposts`, `categories` WHERE `userposts`.`status` = 1 AND `userposts`.`categoryno` = `categories`.`id` ORDER BY `userposts`.`id` DESC ;";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //print_r($row);
            array_push($postslist, $row);
        }
    } else {

        array_push($postslist, NULL);

        echo $conn->error();
    }

    $conn->close();

    return $postslist;
}

<?php

function retrivepostbyid($postid) {
    $postslist = array();
    
    include '../../DAL/dbconnection.php';

    $sql = "SELECT `author`, `name` AS `categoryname`, `userposts`.`datetime` AS `createtime`, `title`, `image`, `post` AS `description` FROM `userposts`, `categories` WHERE `userposts`.`status` = 1 AND `userposts`.`categoryno` = `categories`.`id` AND `userposts`.`id` = $postid;";
    
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


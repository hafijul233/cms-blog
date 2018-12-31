<?php

function searchpostofkey($keyword) 
{
    $postlsist = array();
    
    include '../../DAL/dbconnection.php';

    $sql = "SELECT `datatable`.* FROM( " .
           "SELECT `userposts`.`id`, `categories`.`name` as `categoryname`, `author`, `userposts`.`datetime` AS `posttime`, `title` AS `posttitle`, `post` AS `description`, `image`" .
           " FROM `categories`,`userposts`" .
           " WHERE `categories`.`id` = `userposts`.`categoryno`" .
           " AND `userposts`.`status` = 1)AS `datatable`" .
           " WHERE `categoryname` LIKE '%$keyword%'" .
           " OR `author` LIKE '%$keyword%'" .
           " OR `posttime` LIKE '%$keyword%'" .
           " OR `posttitle` LIKE '%$keyword%'" .
           " OR `description` LIKE '%$keyword%'".
           " ORDER BY `id` DESC;";
   
    //echo $sql;
   
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($postlsist, $row);
        }
    } 
    else {
        
        array_push($postlsist, NULL);
    }

    $conn->close();
    
  return $postlsist;
}

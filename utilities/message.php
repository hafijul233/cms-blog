<?php

function message() {
    if (isset($_SESSION["error"]) && isset($_GET["type"])) {
        $type = $_GET['type'];
        if ($type == 'error')
            echo "<div class =\"alert alert-warning\"><p class=\"text-center\">" . htmlentities($_SESSION["error"]) . "</p></div>";
        else if ($type == 'success')
            echo "<div class =\"alert alert-success\"><p class=\"text-center\">" . htmlentities($_SESSION["error"]) . "</p></div>";
        else if ($type == 'failed')
            echo "<div class =\"alert alert-danger\"><p class=\"text-center\">" . htmlentities($_SESSION["error"]) . "</p></div>";
    
     $_SESSION["error"] = NULL;   
     $type = NULL;
    }
    
}

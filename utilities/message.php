<?php
    
    function message() {
        $output = NULL;
        
        if(isset($_SESSION["error"]) && $_GET["type"]) {
            
            $type = $_GET['type'];
            
            if($type == 'error')
                $output = "<div class =\"alert alert-warning\"><p class=\"text-center\">" . htmlentities($_SESSION["error"]) . "</p></div>";
        
            else if($type == 'success')
               $output = "<div class =\"alert alert-success\"><p class=\"text-center\">" . htmlentities($_SESSION["error"]) . "</p></div>"; 
        
            else if($type == 'failed')
                $output = "<div class =\"alert alert-danger\"><p class=\"text-center\">" . htmlentities($_SESSION["error"]) . "</p></div>";
        
            else 
                $type = NULL;
        }
        
        $_SESSION["error"] = NULL;
        $type = NULL;
        
        return $output;
    }
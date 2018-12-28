<?php

    function categoryvaliadtor($categoryname) 
    {
        if(empty($categoryname)) {
        
            return "Category Name is Empty";
        }
    
        else if (strlen($categoryname) > 100) {
        
            return "Category Name is too Large. Acceptable Size(3 to 100)";
        }
    
        else if (strlen($categoryname) < 3) {
        
            return "Category Name is too Small. Acceptable Size(3 to 100)";
        }
    
        else 
            
            return NULL;
    }
    
    function titlevaliadtor($titlename) 
    {
        if(empty($titlename)) {
        
            return "Title Name is Empty";
        }
    
        else if (strlen($titlename) > 100) {
        
            return "Title Name is too Large. Acceptable Size(3 to 100)";
        }
    
        else if (strlen($titlename) < 3) {
        
            return "Title Name is too Small. Acceptable Size(3 to 100)";
        }
    
        else 
            
            return NULL;
    }

    
    
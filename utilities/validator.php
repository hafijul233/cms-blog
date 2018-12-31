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

    function searchvaliadtor($search)
    {
        $search = strip_tags($search);
        
        $search = filter_var($search, FILTER_UNSAFE_RAW, FILTER_SANITIZE_STRING | FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        
        $search = preg_replace("/[^\w+\p{L}\p{N}\p{Pd}\$\.€%']/", ' ', $search);
        
        return $search;
    }
    
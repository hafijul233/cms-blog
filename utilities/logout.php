<?php
    unset($_SESSION['username']);
    unset($_SESSION['fullname']);
    unset($_SESSION['profilepic']);
    
    session_destroy();
    echo 'i am here';
    print_r($_SESSION);
    //die;
    
    header("Location: ../index.php");

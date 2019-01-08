<?php
//Session Permissions
session_start();

function confirm_login() {
    if (!isset($_SESSION['username']) || !isset($_SESSION['fullname']) || !isset($_SESSION['profilepic'])) {

        $_SESSION['error'] = "System Session Broke Please Login";
        $errortype = "failed";
        header("Location: login.php?type=" . $errortype);
    }
}

//Notification Functions
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

//Validation Functions
function categoryvaliadtor($categoryname) {
    if (empty($categoryname)) {
        return "Category Name is Empty";
    } else if (strlen($categoryname) > 100) {

        return "Category Name is too Large. Acceptable Size(3 to 100)";
    } else if (strlen($categoryname) < 3) {

        return "Category Name is too Small. Acceptable Size(3 to 100)";
    } else
        return NULL;
}

function titlevaliadtor($titlename) {
    if (empty($titlename)) {
        return "Title Name is Empty";
    } else if (strlen($titlename) > 100) {
        return "Title Name is too Large. Acceptable Size(3 to 100)";
    } else if (strlen($titlename) < 3) {
        return "Title Name is too Small. Acceptable Size(3 to 100)";
    } else
        return NULL;
}

function searchvaliadtor($search) {

    $search = strip_tags($search);
    $search = filter_var($search, FILTER_UNSAFE_RAW, FILTER_SANITIZE_STRING | FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    $search = preg_replace("/[^\w+\p{L}\p{N}\p{Pd}\$\.€%']/", ' ', $search);

    return $search;
}

function divremover ($text) {
    
    $text = str_replace("<div>", "", $text);
    $text = str_replace("</div>", "", $text);
    
    return $text;
} 

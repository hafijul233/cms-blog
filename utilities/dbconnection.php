<?php
//Database Connection Access Port
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cmsblog";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    $_SESSION['error'] = "Connection failed: " . $conn->connect_error;
     $errortype = "error";
     header("Location: login.php?type=" . $errortype);
    die;
}

function selectarray($conn, $sql) {
    $arr = [];
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row);
        }
    } else {
        array_push($arr, NULL);
    }
    return $arr;
}

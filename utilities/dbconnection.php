<?php
//Database Connection Access Port
$servername = "localhost";
$username = "root";
$password = "root123";
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
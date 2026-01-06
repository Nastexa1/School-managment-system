<?php
$host = "127.0.0.1";     
$user = "root";          
$pass = "123";           
$dbname = "course_registration";  

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

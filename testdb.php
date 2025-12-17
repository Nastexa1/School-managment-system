<?php
$host = "127.0.0.1";     // localhost
$user = "root";           // username-ka MySQL
$pass = "123";            // password-ka cusub ee root
$dbname = "course_registration";  // database-ka aad abuurtay

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

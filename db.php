<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "123"; 
$dbname = "school_management"; 

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Xiriirka Database-ka waa uu guuldareystay: " . mysqli_connect_error());
}


$expire_time = 10; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['last_activity'] = time();
}

if (isset($_SESSION['username'])) {
    
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $expire_time)) {
        
        session_unset();
        session_destroy();
        
        if (isset($_COOKIE['user_login'])) {
            setcookie("user_login", "", time() - 3600, "/");
        }
        
        header("Location: login.php?msg=session_expired");
        exit();
    }
    
    $_SESSION['last_activity'] = time();
}
?>
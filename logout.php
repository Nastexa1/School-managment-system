<?php
session_start();

$_SESSION = array();

if (isset($_COOKIE['user_login'])) {
    setcookie("user_login", "", time() - 3600, "/");
}

session_destroy();

header("Location: Login.php?msg=logged_out");
exit();
?>
<?php
include 'db.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn,"UPDATE students SET status='inactive' WHERE id=$id");

    header("Location: view_students.php");
    exit;
} else {
    echo "Student ID missing!";
}
?>

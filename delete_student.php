<?php
$conn=mysqli_connect("localhost","root","123","school_management");
if(!$conn){
    die("Connection Field".mysqli_connect_error());
}
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="DELETE FROM students WHERE id=$id";
    mysqli_query($conn,$sql);
    header("Location: view_students.php?status=deleted");
    exit();
}
else{
    header("Location: view_students.php");
    exit();
}
<?php
$conn=mysqli_connect("localhost","root","123","school_management");
if(!$conn){
    die("Connection Filed".mysqli_connect_error());
}
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="DELETE FROM classes WHERE id=$id";
    mysqli_query($conn,$sql);
    header("Location: classes.php?status=deleted");
    exit();

}
else{
    header("Location: classes.php");
    exit();
}
?>
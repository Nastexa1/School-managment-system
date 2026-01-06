<?php
include 'db.php';

$class_name = isset($_GET['class_name']) ? mysqli_real_escape_string($conn, $_GET['class_name']) : '';

if($class_name != "" && $class_name != "0"){
    $sql = "SELECT id, fullName FROM students WHERE class='$class_name'";
} else {
    $sql = "SELECT id, fullName FROM students";
}

$students = mysqli_query($conn, $sql);

echo '<option value="">Choose Student</option>';
while($stu = mysqli_fetch_assoc($students)){
    echo '<option value="'.$stu['id'].'">'.$stu['fullName'].'</option>';
}
?>
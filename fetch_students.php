<?php
$conn = mysqli_connect("localhost","root","123","school_management");
if(!$conn){ die("Connection Failed: ".mysqli_connect_error()); }

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : 0;

if($class_id && $class_id != 0){
    $students = mysqli_query($conn, "SELECT id, fullName FROM students WHERE class='$class_id'");
} else {
    $students = mysqli_query($conn, "SELECT id, fullName FROM students");
}

echo '<option value="">Choose Student</option>';
while($stu = mysqli_fetch_assoc($students)){
    echo '<option value="'.$stu['id'].'">'.$stu['fullName'].'</option>';
}
?>

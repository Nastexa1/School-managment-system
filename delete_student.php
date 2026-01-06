<?php
include 'db.php';

$id = $_GET['id'];

$check = mysqli_query(
  $conn,
  "SELECT id FROM attendance WHERE student_id = $id LIMIT 1"
);

if(mysqli_num_rows($check) > 0){
  echo "<script>
    alert('❌ This student has attendance records. You cannot delete.');
    window.location.href='view_students.php';
  </script>";
  exit;
}

mysqli_query($conn,"DELETE FROM students WHERE id=$id");

header("Location: view_students.php");
exit;

<?php
$message="";
if(isset($_POST["submit"])){
    //datbase conncetion
    $conn=mysqli_connect("localhost","root","123","school_management");
    if(!$conn){
        die("connection field".mysqli_connect_error());
    }
    //Get data
    $id=$_POST['id'];
    $fullName=$_POST['fullName'];
    $Phone=$_POST['Phone'];
    $class=$_POST['class'];
    $MotherName=$_POST["MotherName"];
    $address = $_POST['address'];
    $gender=$_POST['gender'];
$sql = "INSERT INTO students (id, fullName, Phone, class, MotherName, address, gender)
        VALUES ('$id', '$fullName', '$Phone', '$class', '$MotherName', '$address', '$gender')";



if(mysqli_query($conn,$sql)){
        $message = "<p class='text-green-600 font-semibold'>Student added successfully!</p>";


}
else{
        $message = "<p class='text-red-600 font-semibold'>Error: " . mysqli_error($conn) . "</p>";

}
mysqli_close($conn);

}





?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>School Registration</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex">
  <!-- Sidebar -->
    <div class="bg-gray-800 h-[100vh] text-white w-64 flex flex-col">
      <div class="p-6 text-center text-xl font-bold border-b border-gray-700">
        Student Record
      </div>
      <nav class="flex-1 p-4 space-y-2">
        <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-700">
          🏠 Dashboard
        </a>
        <a href="view_students.php" class="flex items-center p-2 rounded hover:bg-gray-700">
          🎓 Students
        </a>
        <a href="add_student.php" class="flex items-center p-2 rounded hover:bg-gray-700">
          ➕ Add Student
        </a>
        <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">
          🏫 Classes
        </a>
        
        <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">
          📝 Grades
        </a>
        <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">
          ✅ Attendence
        </a>
        <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">
          🔓 Logout
        </a>
      </nav>
    </div>

  <!-- Main content -->
  <div class="flex-1 flex justify-center pt-10">
    <div class="bg-white shadow-lg rounded p-8 w-full h-[80vh] max-w-5xl">
      <h1 class="text-2xl font-bold text-center mb-6">Registration Form - School</h1>


      <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Column 1 -->
        <div class="space-y-4">
          <input type="text" name="id" placeholder="Student ID" class="w-full border-2 border-gray-700 py-3 px-4 rounded" required>
          <input type="text" name="fullName" placeholder="Student Name" class="w-full border-2 border-gray-700 py-3 px-4 rounded" required>
          <input type="text" name="Phone" placeholder="Student Phone" class="w-full border-2 border-gray-700 py-3 px-4 rounded" required>
          <input type="text" name="MotherName" placeholder="Mother Name" class="w-full border-2 border-gray-700 py-3 px-4 rounded" required>
        </div>

        <!-- Column 2 -->
        <div class="space-y-4">
<select name="class" class="w-full border-2 border-gray-700 py-3 px-4 rounded" required>
    <option value="">Select Class</option>
    <option value="Class 1">Class 1</option>
    <option value="Class 2">Class 2</option>
    <option value="Class 3">Class 3</option>
</select>
          <input type="text" name="address" placeholder="Address" class="w-full border-2 border-gray-700 py-3 px-4 rounded" required>
          <select name="gender" class="w-full border-2 border-gray-700 py-3 px-4 rounded" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <button type="submit" name="submit" class="w-full bg-gray-800 text-white py-3 rounded hover:bg-gray-900">Register</button>
        </div>
      </form>
         <?php if($message != '') { echo "<div class='mb-4 mt-10 text-center'>$message</div>"; } ?>

    </div>

  </div>

           

</div>

</body>
</html>

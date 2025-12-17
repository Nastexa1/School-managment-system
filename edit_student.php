<?php
// DB Connection
$conn = mysqli_connect("localhost", "root", "123", "school_management");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ======================
// 1. FETCH STUDENT DATA
// ======================
if (!isset($_GET['id'])) {
    header("Location: view_students.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM students WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    echo "Student not found!";
    exit();
}

// ======================
// 2. HANDLE UPDATE FORM
// ======================
if (isset($_POST['update'])) {

    $fullName    = $_POST['fullName'];
    $MotherName  = $_POST['MotherName'];
    $Phone       = $_POST['Phone'];
    $class       = $_POST['class'];
    $address     = $_POST['address'];
    $gender      = $_POST['gender'];

    $update_sql = "
        UPDATE students SET 
            fullName='$fullName',
            MotherName='$MotherName',
            Phone='$Phone',
            class='$class',
            address='$address',
            gender='$gender'
        WHERE id='$id'
    ";

    mysqli_query($conn, $update_sql);

    header("Location: view_students.php?status=updated");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
      <div class="bg-gray-800 text-white w-64 flex flex-col">
    <div class="p-6 text-center text-xl font-bold border-b border-gray-700">
      Student Record
    </div>
    <nav class="flex-1 p-4 space-y-2">
      <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
      <a href="view_students.php" class="flex items-center p-2 rounded hover:bg-gray-700">🎓 Students</a>
      <a href="add_student.php" class="flex items-center p-2 rounded hover:bg-gray-700">➕ Add Student</a>
      <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏫 Classes</a>
      <a href="attendance.php" class="flex items-center p-2 rounded hover:bg-gray-700">✅ Attendance</a>
      <a href="grades.php" class="flex items-center p-2 rounded hover:bg-gray-700">📝 Grades</a>
      <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">🔓 Logout</a>
    </nav>
  </div>
    <!-- End Sidebar -->

    <!-- Content -->
    <div class="flex-1 ml-64 px-10 pt-10">

        <h1 class="text-2xl font-bold mb-6 text-center">Edit Student</h1>

        <form action="" method="POST" class="bg-white p-8 shadow-md rounded-lg w-full max-w-xl mx-auto">

            <label class="block mb-3">
                Full Name:
                <input type="text" name="fullName" value="<?php echo $student['fullName']; ?>"
                       class="w-full px-3 py-2 border rounded">
            </label>

            <label class="block mb-3">
                Mother Name:
                <input type="text" name="MotherName" value="<?php echo $student['MotherName']; ?>"
                       class="w-full px-3 py-2 border rounded">
            </label>

            <label class="block mb-3">
                Phone:
                <input type="text" name="Phone" value="<?php echo $student['Phone']; ?>"
                       class="w-full px-3 py-2 border rounded">
            </label>

            <label class="block mb-3">
                Class:
                <input type="text" name="class" value="<?php echo $student['class']; ?>"
                       class="w-full px-3 py-2 border rounded">
            </label>

            <label class="block mb-3">
                Address:
                <input type="text" name="address" value="<?php echo $student['address']; ?>"
                       class="w-full px-3 py-2 border rounded">
            </label>

            <label class="block mb-3">
                Gender:
                <select name="gender" class="w-full px-3 py-2 border rounded">
                    <option value="Male"   <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </label>

            <button type="submit" name="update"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-800 mt-4">
                Update Student
            </button>

        </form>

    </div>

</div>

</body>
</html>

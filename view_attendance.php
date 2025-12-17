<?php
$conn = mysqli_connect("localhost", "root", "123", "school_management");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$attendance_date = isset($_GET['attendance_date']) ? $_GET['attendance_date'] : date('Y-m-d');
$students = [];

// Fetch students and their attendance if class is selected
if ($class_id != '') {
    // Get class name
    $sql_class = mysqli_query($conn, "SELECT class_name FROM classes WHERE id='$class_id'");
    $class_name = mysqli_fetch_assoc($sql_class)['class_name'];

    // Get students in that class
    $res_students = mysqli_query($conn, "SELECT * FROM students WHERE class='$class_name'");
    while ($stu = mysqli_fetch_assoc($res_students)) {
        $att = mysqli_query($conn, "SELECT status FROM attendance WHERE student_id='{$stu['id']}' AND class_id='$class_id' AND attendance_date='$attendance_date'");
        $status = mysqli_num_rows($att) > 0 ? mysqli_fetch_assoc($att)['status'] : 'Not marked';
        $stu['status'] = $status;
        $students[] = $stu;
    }
}

// Fetch all classes for dropdown
$result_classes = mysqli_query($conn, "SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
    <div class="bg-gray-800 fixed h-[100vh] text-white w-64 flex flex-col">
        <div class="p-6 text-center text-xl font-bold border-b border-gray-700">Student Record</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="block p-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
            <a href="view_students.php" class="block p-2 rounded hover:bg-gray-700">🎓 Students</a>
            <a href="add_student.php" class="block p-2 rounded hover:bg-gray-700">➕ Add Student</a>
            <a href="classes.php" class="block p-2 rounded hover:bg-gray-700">🏫 Classes</a>
            <a href="attendance.php" class="block p-2 rounded hover:bg-gray-700">✅ Attendance</a>
            <a href="grades.php" class="block p-2 rounded hover:bg-gray-700">📝 Grades</a>
            <a href="logout.php" class="block p-2 rounded hover:bg-gray-700">🔓 Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 w-full p-10">

        <h1 class="text-3xl font-bold mb-8">View Attendance</h1>

        <!-- Form Section -->
        <form method="GET" class="flex gap-4 mb-6">
            <select name="class_id" class="w-1/3 border p-2 rounded-lg" onchange="this.form.submit()">
                <option value="">Select Class</option>
                <?php while($c = mysqli_fetch_assoc($result_classes)) { ?>
                    <option value="<?php echo $c['id']; ?>" <?php if($class_id == $c['id']) echo 'selected'; ?>>
                        <?php echo $c['class_name']; ?>
                    </option>
                <?php } ?>
            </select>

            <input type="date" name="attendance_date" value="<?php echo $attendance_date; ?>" class="w-1/3 border p-2 rounded-lg" onchange="this.form.submit()">

            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg">View</button>
        </form>

        <!-- Table Section -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-2xl font-bold mb-4">Attendance List</h2>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">#</th>
                            <th class="py-3 px-4 text-left">Student Name</th>
                            <th class="py-3 px-4 text-left">Roll No</th>
                            <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($students)) {
                            $i = 1;
                            foreach($students as $stu) { ?>
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-3 px-4"><?php echo $i++; ?></td>
                                    <td class="py-3 px-4"><?php echo $stu['fullName']; ?></td>
                                    <td class="py-3 px-4"><?php echo $stu['id']; ?></td>
                                    <td class="py-3 px-4">
                                        <?php if($stu['status'] == 'present') { ?>
                                            <span class="bg-green-200 text-green-700 px-3 py-1 rounded-lg font-semibold">Present</span>
                                        <?php } elseif($stu['status'] == 'absent') { ?>
                                            <span class="bg-red-200 text-red-700 px-3 py-1 rounded-lg font-semibold">Absent</span>
                                        <?php } else { ?>
                                            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg font-semibold">Not marked</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="4" class="py-3 px-4 text-center text-red-600">No students found for this class.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

</body>
</html>

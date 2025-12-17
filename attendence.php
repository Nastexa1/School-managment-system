<?php
$conn = mysqli_connect("localhost","root","123","school_management");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$date = isset($_GET['attendance_date']) ? $_GET['attendance_date'] : date('Y-m-d');

$students = [];
$message = "";

// SAVE ATTENDANCE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $attendance_date = $_POST['attendance_date'];

    foreach ($_POST['attendance'] as $student_id => $status) {
        $check = mysqli_query($conn,"SELECT id FROM attendance 
            WHERE student_id='$student_id' AND class_id='$class_id' AND attendance_date='$attendance_date'");

        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn,"UPDATE attendance 
                SET status='$status'
                WHERE student_id='$student_id' AND class_id='$class_id' AND attendance_date='$attendance_date'");
        } else {
            mysqli_query($conn,"INSERT INTO attendance (student_id,class_id,attendance_date,status)
                VALUES('$student_id','$class_id','$attendance_date','$status')");
        }
    }

    $message = "Attendance Saved Successfully!";
}

// LOAD STUDENTS WHEN CLASS SELECTED
if ($id != "") {
    $q_class = mysqli_query($conn, "SELECT class_name FROM classes WHERE id='$id'");
    $class_name = mysqli_fetch_assoc($q_class)['class_name'];

    $q_stu = mysqli_query($conn,"SELECT * FROM students WHERE class='$class_name'");
    while ($row = mysqli_fetch_assoc($q_stu)) {
        $get_att = mysqli_query($conn,"SELECT status FROM attendance 
            WHERE student_id='{$row['id']}' AND class_id='$id' AND attendance_date='$date'");

        $row['status'] = (mysqli_num_rows($get_att) > 0) ? mysqli_fetch_assoc($get_att)['status'] : "";
        $students[] = $row;
    }
}

// GET ALL CLASSES
$result_classes = mysqli_query($conn,"SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
<title>Attendance</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <div class="bg-gray-800 fixed h-[100vh] text-white w-64 flex flex-col">
        <div class="p-6 text-center text-xl font-bold border-b border-gray-700">School Admin</div>
        <nav class="flex-1 p-4 space-y-2">

            <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
            <a href="view_students.php" class="flex items-center p-2 rounded hover:bg-gray-700">🎓 Students</a>
            <a href="add_student.php" class="flex items-center p-2 rounded hover:bg-gray-700">➕ Add Student</a>
            <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏫 Classes</a>

            <a href="#" class="flex items-center p-2 rounded bg-gray-700">✅ Attendance</a>

            <a href="view_attendance.php" class="flex items-center p-2 rounded hover:bg-gray-700">📊 View Attendance</a>

            <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">🔓 Logout</a>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="ml-64 w-full p-8">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">Attendance Management</h1>

        <?php if ($message != "") { ?>
            <p class="bg-green-200 text-green-700 p-3 rounded mb-4"><?php echo $message; ?></p>
        <?php } ?>

        <!-- CLASS + DATE SELECTOR -->
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="font-semibold text-gray-700">Select Class</label>
                <select name="id" class="w-full border p-2 rounded" onchange="this.form.submit()">
                    <option value="">Choose Class</option>
                    <?php while($c = mysqli_fetch_assoc($result_classes)) { ?>
                        <option value="<?php echo $c['id']; ?>" <?php if($id == $c['id']) echo "selected"; ?>>
                            <?php echo $c['class_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Date</label>
                <input type="date" name="attendance_date"
                       value="<?php echo $date; ?>"
                       class="w-full border p-2 rounded"
                       onchange="this.form.submit()">
            </div>

           <a href="view_attendance.php"
   class="bg-gray-800 text-white rounded px-[90px] py-2 mt-6 inline-block">
   View attendance
</a>

        </form>


        <!-- TABLE -->
        <?php if (!empty($students)) { ?>
        <form method="POST">

            <input type="hidden" name="class_id" value="<?php echo $id; ?>">
            <input type="hidden" name="attendance_date" value="<?php echo $date; ?>">

            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-900 text-white">
                            <th class="p-3 border">#</th>
                            <th class="p-3 border">Student Name</th>
                            <th class="p-3 border">Roll</th>
                            <th class="p-3 border">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; foreach ($students as $stu) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="p-3 border"><?php echo $i++; ?></td>
                            <td class="p-3 border"><?php echo $stu['fullName']; ?></td>
                            <td class="p-3 border"><?php echo $stu['id']; ?></td>

                            <td class="p-3 border">
                                <div class="flex items-center gap-6">
                                    
                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[<?php echo $stu['id']; ?>]" value="present"
                                               <?php if($stu['status']=="present") echo "checked"; ?>>
                                        <span class="ml-2 text-green-700 font-semibold">Present</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="radio" name="attendance[<?php echo $stu['id']; ?>]" value="absent"
                                               <?php if($stu['status']=="absent") echo "checked"; ?>>
                                        <span class="ml-2 text-red-600 font-semibold">Absent</span>
                                    </label>

                                </div>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <button type="submit"
                class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded text-lg font-semibold">
                Save Attendance
            </button>

        </form>

        <?php } elseif ($id != "") { ?>
            <p class="text-red-600">No students found in this class.</p>
        <?php } ?>

    </div>

</div>

</body>
</html>

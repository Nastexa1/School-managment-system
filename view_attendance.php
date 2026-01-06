<?php
include 'db.php';

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$attendance_date = isset($_GET['attendance_date']) ? $_GET['attendance_date'] : date('Y-m-d');
$students = [];

if ($class_id != '') {
    $sql_class = mysqli_query($conn, "SELECT class_name FROM classes WHERE id='$class_id'");
    $class_name = mysqli_fetch_assoc($sql_class)['class_name'];

    $res_students = mysqli_query($conn, "SELECT * FROM students WHERE class='$class_name'");
    while ($stu = mysqli_fetch_assoc($res_students)) {
        $att = mysqli_query($conn, "SELECT status FROM attendance WHERE student_id='{$stu['id']}' AND class_id='$class_id' AND attendance_date='$attendance_date'");
        $status = mysqli_num_rows($att) > 0 ? mysqli_fetch_assoc($att)['status'] : 'Not marked';
        $stu['status'] = $status;
        $students[] = $stu;
    }
}

$result_classes = mysqli_query($conn, "SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex">

    <aside class="w-72 fixed bg-slate-900 h-[100vh] text-slate-300 flex flex-col shadow-2xl z-10">
        <div class="p-8 text-center border-b border-slate-800 flex">
            <div class="bg-blue-600 w-12 h-12 rounded-lg flex items-center justify-center mx-auto  shadow-lg shadow-blue-500/50">
                <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
            </div>
            <span class="text-white text-xl font-bold tracking-tight mt-2">SCHOOL SYSTEM</span>
        </div>

        <nav class="flex-1 p-6 space-y-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-4">Main Menu</p>
            <a href="dashboard.php" class="flex items-center space-x-4 bg-blue-600/10 text-blue-400 p-3 rounded-xl border border-blue-600/20 transition-all">
                <i class="fa-solid fa-house w-5 text-center"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="profile.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
    <i class="fa-solid fa-user-circle w-5 text-center group-hover:text-blue-400"></i>
    <span class="font-medium">Profile</span>
</a>
            <a href="view_students.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
                <i class="fa-solid fa-user-graduate w-5 text-center group-hover:text-blue-400"></i>
                <span class="font-medium">Students</span>
            </a>
            <a href="add_student.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
                <i class="fa-solid fa-user-plus w-5 text-center group-hover:text-blue-400"></i>
                <span class="font-medium">Add Student</span>
            </a>
            <a href="classes.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
                <i class="fa-solid fa-chalkboard-user w-5 text-center group-hover:text-blue-400"></i>
                <span class="font-medium">Classes</span>
            </a>
            <a href="attendence.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
                <i class="fa-solid fa-calendar-check w-5 text-center group-hover:text-blue-400"></i>
                <span class="font-medium">Attendance</span>
            </a>
            <a href="grades.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
                <i class="fa-solid fa-file-invoice w-5 text-center group-hover:text-blue-400"></i>
                <span class="font-medium">Grades</span>
            </a>
            
            <div class="">
                <a href="logout.php" class="flex items-center space-x-4 bg-red-500/5 text-red-500 hover:bg-red-500 hover:text-white p-3 rounded-xl transition-all">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </div>
        </nav>
    </aside>

    <div class="ml-64 w-full p-10">

        <h1 class="text-3xl font-bold mb-8">View Attendance</h1>

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

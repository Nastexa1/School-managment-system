<?php
include 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$date = isset($_GET['attendance_date']) ? $_GET['attendance_date'] : date('Y-m-d');

$students = [];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
    $class_id = $_POST['class_id'];
    $attendance_date = $_POST['attendance_date'];

    foreach ($_POST['attendance'] as $student_id => $status) {
        $stmt = $conn->prepare("SELECT id FROM attendance WHERE student_id=? AND class_id=? AND attendance_date=?");
        $stmt->bind_param("iis", $student_id, $class_id, $attendance_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $update = $conn->prepare("UPDATE attendance SET status=? WHERE student_id=? AND class_id=? AND attendance_date=?");
            $update->bind_param("siis", $status, $student_id, $class_id, $attendance_date);
            $update->execute();
        } else {
            $insert = $conn->prepare("INSERT INTO attendance (student_id, class_id, attendance_date, status) VALUES (?, ?, ?, ?)");
            $insert->bind_param("iiss", $student_id, $class_id, $attendance_date, $status);
            $insert->execute();
        }
    }
    $message = "Attendance Saved Successfully!";
}

if ($id != "") {
    $stmt_c = $conn->prepare("SELECT class_name FROM classes WHERE id=?");
    $stmt_c->bind_param("i", $id);
    $stmt_c->execute();
    $res_c = $stmt_c->get_result();
    $class_data = $res_c->fetch_assoc();

    if ($class_data) {
        $class_name = $class_data['class_name'];
        
        $class_with_space = (strpos($class_name, ' ') === false) ? str_replace("Class", "Class ", $class_name) : $class_name;
        $class_no_space = str_replace(" ", "", $class_name);
        
        $query = "SELECT s.id, s.fullName, a.status 
                  FROM students s 
                  LEFT JOIN attendance a ON s.id = a.student_id AND a.attendance_date = ? AND a.class_id = ?
                  WHERE (s.class = ? OR s.class = ?) AND s.status = 'active'";
        
        $stmt_s = $conn->prepare($query);
        $stmt_s->bind_param("siss", $date, $id, $class_name, $class_with_space);
        $stmt_s->execute();
        $result_s = $stmt_s->get_result();
        
        while ($row = $result_s->fetch_assoc()) {
            $students[] = $row;
        }
    }
}

$result_classes = mysqli_query($conn, "SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

<div div class="flex">

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

    <div class="ml-64 w-full p-[24px] ml-[300px]">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Attendance Management</h1>
            <p class="text-gray-500 font-medium"><?php echo date('l, d M Y'); ?></p>
        </div>

        <?php if ($message != ""): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-sm mb-8 border border-gray-200">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Select Class</label>
                    <select name="id" class="w-full border-gray-300 border p-2.5 rounded-md" onchange="this.form.submit()">
                        <option value="">-- Choose Class --</option>
                        <?php while($c = mysqli_fetch_assoc($result_classes)): ?>
                            <option value="<?php echo $c['id']; ?>" <?php echo ($id == $c['id']) ? 'selected' : ''; ?>>
                                <?php echo $c['class_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Date</label>
                    <input type="date" name="attendance_date" value="<?php echo $date; ?>" 
                           class="w-full border-gray-300 border p-2 rounded-md" onchange="this.form.submit()">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded hover:bg-blue-700 transition">Search</button>
                    <a href="view_attendance.php" class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded hover:bg-gray-300 transition text-center">History</a>
                </div>
            </form>
        </div>

        <?php if (!empty($students)): ?>
        <form method="POST">
            <input type="hidden" name="class_id" value="<?php echo $id; ?>">
            <input type="hidden" name="attendance_date" value="<?php echo $date; ?>">

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="p-4 border-b border-gray-700">#</th>
                            <th class="p-4 border-b border-gray-700">Roll No</th>
                            <th class="p-4 border-b border-gray-700">Full Name</th>
                            <th class="p-4 border-b border-gray-700">Attendance Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                       <?php $i = 1; foreach ($students as $stu): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-4"><?php echo $i++; ?></td>
                            <td class="p-4 font-semibold text-blue-600"><?php echo $stu['id']; ?></td>
                            <td class="p-4"><?php echo $stu['fullName']; ?></td>
                            <td class="p-4">
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="attendance[<?php echo $stu['id']; ?>]" value="present" 
                                               <?php echo ($stu['status'] == "present") ? "checked" : ""; ?> 
                                               class="w-4 h-4 text-green-600" required>
                                        <span class="ml-2 text-green-700 font-bold">Present</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="attendance[<?php echo $stu['id']; ?>]" value="absent" 
                                               <?php echo ($stu['status'] == "absent") ? "checked" : ""; ?>
                                               class="w-4 h-4 text-red-600">
                                        <span class="ml-2 text-red-700 font-bold">Absent</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="p-6 bg-gray-50 border-t">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-bold text-lg shadow-md transition">
                        Save Attendance
                    </button>
                </div>
            </div>
        </form>
        <?php elseif ($id != ""): ?>
            <div class="bg-white p-12 text-center rounded-lg shadow">
                <p class="text-red-500 text-xl font-semibold">No active students found in this class.</p>
                <p class="text-gray-400 mt-2">Hubi in ardaydu ay "Active" yihiin oo ay ku qoran yihiin fasalka saxda ah.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
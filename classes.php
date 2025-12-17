<?php
$conn = mysqli_connect("localhost","root","123","school_management");
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

// Get class_id from URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

$class_name = '';
$students = [];
$total_students = 0;

if($id != ''){
    // Fetch class name
    $sql_class = "SELECT * FROM classes WHERE id='$id'";
    $res_class = mysqli_query($conn, $sql_class);
    if($res_class && mysqli_num_rows($res_class) > 0){
        $class_row = mysqli_fetch_assoc($res_class);
        $class_name = $class_row['class_name'];

        // Fetch students in this class who are registered (assuming all in students table are registered)
        // If you have a 'status' column, you can filter WHERE status='registered'
        $sql_students = "SELECT * FROM students WHERE class='$class_name'";
        $res_students = mysqli_query($conn, $sql_students);
        if($res_students){
            while($row = mysqli_fetch_assoc($res_students)){
                $students[] = $row;
            }
            $total_students = count($students);
        }
    }
}

// Fetch all classes
$sql_all_classes = "SELECT * FROM classes";
$result_classes = mysqli_query($conn, $sql_all_classes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Classes & Students</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
    <div class="bg-gray-800 fixed h-[100vh] text-white w-64 flex flex-col">
        <div class="p-6 text-center text-xl font-bold border-b border-gray-700">Student Record</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
            <a href="view_students.php" class="flex items-center p-2 rounded hover:bg-gray-700">🎓 Students</a>
            <a href="add_student.php" class="flex items-center p-2 rounded hover:bg-gray-700">➕ Add Student</a>
            <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏫 Classes</a>
            <a href="grades.php" class="flex items-center p-2 rounded hover:bg-gray-700">📝 Grades</a>
            <a href="attendence.php" class="flex items-center p-2 rounded hover:bg-gray-700">✅ Attendance</a>
            <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">🔓 Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 px-10 pt-10 ml-64">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">All Classes</h1>
        </div>

        <!-- Classes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <?php while($row = mysqli_fetch_assoc($result_classes)){ ?>
            <div class="bg-gray-800 text-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-lg font-bold mb-2"><?php echo $row['class_name']; ?></h2>
                <p class="text-gray-100"><?php echo $row['description']; ?></p>
                <div class="flex gap-3 mt-3">
                    <a href="?id=<?php echo $row['id']; ?>" class="bg-blue-600 px-3 py-1 rounded text-white hover:bg-blue-800">View Students</a>
                    <a href="#" class="text-yellow-500 hover:text-yellow-700"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="delete_classes.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:text-red-800"><i class="fa-solid fa-trash"></i></a>
                </div>
            </div>
        <?php } ?>
        </div>

        <!-- Students Table -->
        <?php if($id != ''){ ?>
        <div class="mb-6">
            <h2 class="text-xl font-bold mb-2">Students in <?php echo $class_name; ?> (Total: <?php echo $total_students; ?>)</h2>
            <?php if(!empty($students)){ ?>
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3 border">#</th>
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">Roll</th>
                            <th class="p-3 border">Phone</th>
                            <th class="p-3 border">Mother Name</th>
                            <th class="p-3 border">Address</th>
                            <th class="p-3 border">Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($students as $stu){ ?>
                        <tr>
                            <td class="p-3 border"><?php echo $i++; ?></td>
                            <td class="p-3 border"><?php echo $stu['fullName']; ?></td>
                            <td class="p-3 border"><?php echo $stu['id']; ?></td>
                            <td class="p-3 border"><?php echo $stu['Phone']; ?></td>
                            <td class="p-3 border"><?php echo $stu['MotherName']; ?></td>
                            <td class="p-3 border"><?php echo $stu['address']; ?></td>
                            <td class="p-3 border"><?php echo ucfirst($stu['gender']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <p class="mt-4 text-red-600">No students registered in this class.</p>
            <?php } ?>
        </div>
        <?php } ?>

    </div>
</div>
</body>
</html>

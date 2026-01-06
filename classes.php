<?php
include 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

$class_name = '';
$students = [];
$total_students = 0;

if($id != ''){
    $sql_class = "SELECT * FROM classes WHERE id='$id'";
    $res_class = mysqli_query($conn, $sql_class);
    if($res_class && mysqli_num_rows($res_class) > 0){
        $class_row = mysqli_fetch_assoc($res_class);
        $class_name = $class_row['class_name'];

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
    



    <div class="flex-1 px-10 pt-10 ml-64">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">All Classes</h1>
            <a href="add_class.php" class="bg-blue-600 px-10 py-2 text-white rounded">
                AddClass
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <?php while($row = mysqli_fetch_assoc($result_classes)){ ?>
            <div class="bg-white text-black p-4 rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-lg font-bold mb-2"><?php echo $row['class_name']; ?></h2>
                <p class="text-black"><?php echo $row['description']; ?></p>
                <div class="flex gap-3 mt-3">
                    <a href="?id=<?php echo $row['id']; ?>" class="bg-blue-600 px-3 py-1 rounded text-white hover:bg-blue-800">View Students</a>
                    <a href="#" class="text-yellow-500 hover:text-yellow-700"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="delete_classes.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:text-red-800"><i class="fa-solid fa-trash"></i></a>
                </div>
            </div>
        <?php } ?>
        </div>

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

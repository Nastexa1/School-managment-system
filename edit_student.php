<?php
// DB Connection
include 'db.php';

// 1. FETCH STUDENT DATA
if (!isset($_GET['id'])) {
    header("Location: view_students.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']); // Amniga: Escaping ID
$sql = "SELECT * FROM students WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    echo "Student not found!";
    exit();
}

// 2. HANDLE UPDATE FORM
if (isset($_POST['update'])) {
    $fullName    = mysqli_real_escape_string($conn, $_POST['fullName']);
    $MotherName  = mysqli_real_escape_string($conn, $_POST['MotherName']);
    $Phone       = mysqli_real_escape_string($conn, $_POST['Phone']);
    $class       = mysqli_real_escape_string($conn, $_POST['class']);
    $address     = mysqli_real_escape_string($conn, $_POST['address']);
    $gender      = mysqli_real_escape_string($conn, $_POST['gender']);

    $update_sql = "UPDATE students SET 
        fullName='$fullName',
        MotherName='$MotherName',
        Phone='$Phone',
        class='$class',
        address='$address',
        gender='$gender'
        WHERE id='$id'";

    if(mysqli_query($conn, $update_sql)){
        header("Location: view_students.php?status=updated");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student | School System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .input-focus:focus { border-color: #2563eb; ring: 2px; ring-color: #3b82f6; }
    </style>
</head>
<body class="bg-slate-50">

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

    <main class="flex-1 ml-72 p-12">
        
        <div class="max-w-4xl mx-auto mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800">Edit Student Profile</h1>
                <p class="text-slate-500 mt-1">Update information for <span class="text-blue-600 font-semibold"><?php echo $student['fullName']; ?></span></p>
            </div>
            <a href="view_students.php" class="bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm font-medium">
                <i class="fa-solid fa-arrow-left text-sm"></i> Back to List
            </a>
        </div>

        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-blue-600 p-1"></div> <form action="" method="POST" class="p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Full Name</label>
                        <div class="relative group">
                            <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="fullName" value="<?php echo $student['fullName']; ?>" 
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Mother Name</label>
                        <div class="relative group">
                            <i class="fa-solid fa-person-breastfeeding absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500"></i>
                            <input type="text" name="MotherName" value="<?php echo $student['MotherName']; ?>" 
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Phone Number</label>
                        <div class="relative group">
                            <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500"></i>
                            <input type="text" name="Phone" value="<?php echo $student['Phone']; ?>" 
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Class/Grade</label>
                        <div class="relative group">
                            <i class="fa-solid fa-chalkboard absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500"></i>
                            <input type="text" name="class" value="<?php echo $student['class']; ?>" 
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all" required>
                        </div>
                    </div>

                    <div class="space-y-2 md:col-span-1">
                        <label class="text-sm font-bold text-slate-700 ml-1">Residential Address</label>
                        <div class="relative group">
                            <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500"></i>
                            <input type="text" name="address" value="<?php echo $student['address']; ?>" 
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all" required>
                        </div>
                    </div>

                    <div class="space-y-2 md:col-span-1">
                        <label class="text-sm font-bold text-slate-700 ml-1">Gender</label>
                        <div class="relative group">
                            <i class="fa-solid fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500"></i>
                            <select name="gender" class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 appearance-none transition-all cursor-pointer">
                                <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="mt-12 flex items-center justify-end space-x-4 border-t border-slate-100 pt-8">
                    <button type="reset" class="px-8 py-3.5 text-slate-500 font-bold hover:text-slate-800 transition-all">
                        Reset Changes
                    </button>
                    <button type="submit" name="update" class="bg-blue-600 text-white px-10 py-3.5 rounded-2xl font-bold hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-200 active:scale-95 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        Save Updates
                    </button>
                </div>

            </form>
        </div>

        <p class="text-center text-slate-400 text-xs mt-8 uppercase tracking-widest font-bold">School Management System © 2024</p>
    </main>

</div>

</body>
</html>
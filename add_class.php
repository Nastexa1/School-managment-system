<?php
include 'db.php';

$message = "";

if (isset($_POST['submit'])) {
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($class_name)) {
        $sql = "INSERT INTO classes (class_name, description) VALUES ('$class_name', '$description')";
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>Class added successfully!</div>";
        } else {
            $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $message = "<div class='bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4'>Class name is required.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Class</title>
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


        <div class="flex-1 px-10 pt-10 mt-30 ml-[550px]">
            <div class="max-w-2xl bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold text-slate-800">Add New Class</h1>
                    <a href="classes.php" class="text-blue-600 hover:underline"><i class="fa-solid fa-arrow-left mr-2"></i>Back to List</a>
                </div>

                <?php echo $message; ?>

                <form action="" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Class Name</label>
                        <input type="text" name="class_name" placeholder="e.g. Grade 10-A" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Description / Room No.</label>
                        <textarea name="description" rows="4" placeholder="Brief description of the class..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"></textarea>
                    </div>

                    <button type="submit" name="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-500/30 transition-all transform active:scale-[0.98]">
                        <i class="fa-solid fa-plus mr-2"></i> Create Class
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
include 'db.php';

$status_filter = isset($_GET['status']) ? $_GET['status'] : 'active';

if($status_filter == 'all'){
    $sql = "SELECT * FROM students";
}else{
    $sql = "SELECT * FROM students WHERE status='$status_filter'";
}
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Directory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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

    <main class="flex-1 ml-72 p-10">
        
        <header class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Student Records</h1>
                <p class="text-slate-500 text-sm">Managing student information and enrollment status.</p>
            </div>
            
            <form method="GET" class="flex items-center bg-white shadow-sm border border-slate-200 rounded-xl px-4 py-2 space-x-3">
                <label for="status" class="text-xs font-bold text-slate-400 uppercase tracking-wider">Show:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="bg-transparent text-sm font-bold focus:outline-none cursor-pointer text-slate-700">
                    <option value="active" <?php if($status_filter=='active') echo 'selected'; ?>>Active</option>
                    <option value="inactive" <?php if($status_filter=='inactive') echo 'selected'; ?>>Inactive</option>
                    <option value="all" <?php if($status_filter=='all') echo 'selected'; ?>>All Students</option>
                </select>
            </form>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 uppercase text-[11px] tracking-widest font-bold">
                            <th class="px-6 py-4 border-b border-slate-100">ID</th>
                            <th class="px-6 py-4 border-b border-slate-100">Student Name</th>
                            <th class="px-6 py-4 border-b border-slate-100">Mother Name</th>
                            <th class="px-6 py-4 border-b border-slate-100">Phone</th>
                            <th class="px-6 py-4 border-b border-slate-100">Class</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-400 text-sm">#<?php echo $row['id']; ?></td>
                            <td class="px-6 py-4 font-semibold text-slate-800"><?php echo $row['fullName']; ?></td>
                            <td class="px-6 py-4 text-slate-500 text-sm"><?php echo $row['MotherName']; ?></td>
                            <td class="px-6 py-4 text-sm"><?php echo $row['Phone']; ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-bold">
                                    <?php echo $row['class']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="edit_student.php?id=<?php echo $row['id']; ?>" 
                                       class="text-blue-600 hover:text-blue-800 text-xs font-bold uppercase tracking-wider">
                                       Edit
                                    </a>

                                    <span class="text-slate-200">|</span>

                                    <?php if($row['status']=='active'){ ?>
                                        <a href="deactivate_student.php?id=<?php echo $row['id']; ?>" 
                                           onclick="return confirm('Are you sure to deactivate?');" 
                                           class="text-orange-500 hover:text-orange-700 text-xs font-bold uppercase tracking-wider">
                                            Deactivate
                                        </a>
                                    <?php } else { ?>
                                        <a href="activate_student.php?id=<?php echo $row['id']; ?>" 
                                           onclick="return confirm('Are you sure to activate?');" 
                                           class="text-green-500 hover:text-green-700 text-xs font-bold uppercase tracking-wider">
                                            Activate
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <?php if(mysqli_num_rows($result) == 0): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm italic">
                                No records found for this category.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

</body>
</html>
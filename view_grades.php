<?php
include 'db.php';
$classes = mysqli_query($conn, "SELECT id, class_name FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
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
        <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Check Student Marks</h1>
        <p class="text-slate-500 mb-8">Dooro fasalka iyo ardayga si aad u aragto darajooyinka.</p>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">1. Select Class</label>
                    <select id="class_select" class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 font-semibold transition-all">
                        <option value="">-- Choose Class --</option>
                        <?php while($cl=mysqli_fetch_assoc($classes)): ?>
                            <option value="<?= $cl['class_name'] ?>"><?= $cl['class_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">2. Select Student</label>
                    <select id="student_select" class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 font-semibold transition-all">
                        <option value="">-- Choose Student --</option>
                    </select>
                </div>
            </div>

            <div id="marks_display" class="min-h-[200px] flex items-center justify-center border-2 border-dashed border-slate-100 rounded-[2rem]">
                <div class="text-center text-slate-300">
                    <i class="fa-solid fa-search text-5xl mb-3"></i>
                    <p class="font-medium">Xogta halkan ayay ku soo bixi doontaa...</p>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
$(document).ready(function(){
    // Markii Class la doorto
    $('#class_select').change(function(){
        var class_id = $(this).val();
        if(class_id != ""){
            $.ajax({
                url: 'fetch_students.php',
                method: 'GET',
                data: { class_id: class_id },
                success: function(data){
                    $('#student_select').html(data);
                    $('#marks_display').html('<p class="text-slate-400">Hadda dooro ardayga...</p>');
                }
            });
        }
    });

    // Markii Student la doorto
    $('#student_select').change(function(){
        var student_id = $(this).val();
        if(student_id != ""){
            $.ajax({
                url: 'get_marks_ajax.php',
                method: 'POST',
                data: { student_id: student_id },
                success: function(response){
                    $('#marks_display').html(response);
                }
            });
        }
    });
});
</script>
</body>
</html>
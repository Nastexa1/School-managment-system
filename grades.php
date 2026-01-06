<?php
include 'db.php';

$message = "";

$subjects = [
    "English", "Math", "Tarbiyo", "Somali", 
    "Science", "Arabic", "Geography", "History"
];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_grade'])){
    $student_id = $_POST['student_id'];
    $class_id   = $_POST['class_id']; 
    $total = 0;

    for($i=0; $i<8; $i++){
        $val = $_POST['sub_' . $i];
        $marks[$i] = $val;
        $total += $val;
    }

    $average = $total / 8;

    if($average >= 90){ $grade="A"; }
    elseif($average >= 80){ $grade="B"; }
    elseif($average >= 70){ $grade="C"; }
    elseif($average >= 60){ $grade="D"; }
    else{ $grade="Failed"; }

    $sql = "INSERT INTO grades 
            (student_id, class_id, subject1, subject2, subject3, subject4, subject5, subject6, subject7, subject8, total, average, grade)
            VALUES ('$student_id', '$class_id', '{$marks[0]}', '{$marks[1]}', '{$marks[2]}', '{$marks[3]}', '{$marks[4]}', '{$marks[5]}', '{$marks[6]}', '{$marks[7]}', '$total', '$average', '$grade')";

    if(mysqli_query($conn, $sql)){ 
        $message = "Grades Saved Successfully!"; 
    } else { 
        $message = "Error: " . mysqli_error($conn); 
    }
}

$classes = mysqli_query($conn, "SELECT id, class_name FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Entry - Official Subjects</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <div class="flex-1 p-8 ml-72">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Enter Student Grades</h1>
            <a href="view_grades.php" class="bg-white text-blue-600 px-6 py-2 rounded-xl font-bold shadow-sm border border-blue-100 hover:bg-blue-50 transition">View All Grades</a>
        </div>

        <?php if($message != ""): ?>
            <div class="p-4 bg-green-100 text-green-700 rounded-2xl mb-6 font-bold border border-green-200 shadow-sm">
                <i class="fa-solid fa-circle-check mr-2"></i> <?= $message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-xl rounded-[2rem] p-8 border border-gray-100">
            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">1. Select Class</label>
                <select id="class_select" class="w-full p-4 border-2 border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition font-semibold text-gray-700 bg-gray-50">
                    <option value="0">-- Choose Class --</option>
                    <?php mysqli_data_seek($classes, 0); while($cl=mysqli_fetch_assoc($classes)): ?>
                        <option value="<?= $cl['id'] ?>" data-name="<?= $cl['class_name'] ?>"><?= $cl['class_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <form method="POST" id="grades_form" class="space-y-8">
                <div>
                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">2. Select Student</label>
                    <select name="student_id" id="student_select" class="w-full p-4 border-2 border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition font-semibold text-gray-700 bg-gray-50" required>
                        <option value="">Choose Student</option>
                    </select>
                </div>

                <input type="hidden" name="class_id" id="hidden_class_id">

                <div class="pt-6 border-t border-gray-50">
                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">3. Enter Marks (0-100)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach($subjects as $index => $sub): ?>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <label class="block font-bold text-gray-700 mb-2 text-sm uppercase"><?= $sub ?></label>
                                <input type="number" name="sub_<?= $index ?>" 
                                       class="w-full p-3 border-2 border-white rounded-xl focus:border-blue-500 outline-none transition font-bold text-blue-600 shadow-sm" 
                                       placeholder="0" min="0" max="100" required>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="text-center pt-8">
                    <button type="submit" name="save_grade" class="bg-blue-600 text-white py-4 px-16 rounded-2xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Save Examination Grades
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    function loadStudents(class_id, class_name){
        $.ajax({
            url: 'fetch_students.php',
            method: 'GET',
            data: { class_name: class_name },
            success: function(response){
                $('#student_select').html(response);
                $('#hidden_class_id').val(class_id);
            }
        });
    }

    $('#class_select').change(function(){
        var class_id = $(this).val(); 
        var class_name = $(this).find(':selected').data('name');
        loadStudents(class_id, class_name);
    });
});
</script>
</body>
</html>
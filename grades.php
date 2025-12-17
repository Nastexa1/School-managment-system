<?php
$conn = mysqli_connect("localhost","root","123","school_management");
if(!$conn){ die("Connection Failed: ".mysqli_connect_error()); }

$message = "";

// Save grades
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_grade'])){
    $student_id = $_POST['student_id'];
    $class_id   = $_POST['class_id'];
    $total = 0;

    for($i=1;$i<=8;$i++){
        ${"s$i"} = $_POST["subject$i"];
        $total += ${"s$i"};
    }

    $average = $total / 8;

    if($average >= 90){ $grade="A"; }
    elseif($average >= 80){ $grade="B"; }
    elseif($average >= 70){ $grade="C"; }
    elseif($average >= 60){ $grade="D"; }
    else{ $grade="Failed"; }

    $sql = "INSERT INTO grades 
            (student_id,class_id,subject1,subject2,subject3,subject4,subject5,subject6,subject7,subject8,total,average,grade)
            VALUES ('$student_id','$class_id','$s1','$s2','$s3','$s4','$s5','$s6','$s7','$s8','$total','$average','$grade')";

    if(mysqli_query($conn,$sql)){ $message="Grades Saved Successfully!"; }
    else{ $message="Error: ".mysqli_error($conn); }
}

// Fetch classes
$classes = mysqli_query($conn, "SELECT id,class_name FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Grade Entry AJAX</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- Sidebar -->
    <div class="bg-gray-800 fixed h-full text-white w-64 flex flex-col">
        <div class="p-6 text-center text-xl font-bold border-b border-gray-700">Student Record</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
            <a href="view_students.php" class="flex items-center p-2 rounded hover:bg-gray-700">🎓 Students</a>
            <a href="add_student.php" class="flex items-center p-2 rounded hover:bg-gray-700">➕ Add Student</a>
            <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏫 Classes</a>
            <a href="grades.php" class="flex items-center p-2 rounded hover:bg-gray-700 bg-gray-700">📝 Grades</a>
            <a href="attendence.php" class="flex items-center p-2 rounded hover:bg-gray-700">✅ Attendance</a>
            <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">🔓 Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-auto ml-64">

        <h1 class="text-3xl font-bold mb-6">Enter Student Grades</h1>

        <?php if($message != ""): ?>
            <div class="p-4 bg-green-200 text-green-800 rounded mb-6">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <!-- Class Select -->
        <label class="font-semibold">Select Class</label>
        <select id="class_select" class="border p-2 rounded w-full mb-6">
            <option value="0">All Classes</option>
            <?php while($cl=mysqli_fetch_assoc($classes)): ?>
                <option value="<?= $cl['id'] ?>"><?= $cl['class_name'] ?></option>
            <?php endwhile; ?>
        </select>

        <!-- Grades Form -->
        <form method="POST" id="grades_form" class="bg-white shadow-lg rounded-xl p-8">

            <label class="font-semibold">Select Student</label>
            <select name="student_id" id="student_select" class="border w-full p-3 rounded-lg mb-6" required>
                <option value="">Choose Student</option>
            </select>

            <input type="hidden" name="class_id" id="hidden_class_id">

            <!-- Subjects -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php for($i=1;$i<=8;$i++): ?>
                    <div>
                        <label class="font-semibold">Subject <?= $i ?></label>
                        <input type="number" name="subject<?= $i ?>" class="border w-full p-3 rounded-lg mt-1" placeholder="Marks 0-100" required>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="text-center mt-10">
                <button type="submit" name="save_grade" class="bg-blue-600 text-white py-3 px-10 rounded-lg font-bold hover:bg-blue-700 transition">
                    Save Grades
                </button>
            </div>
        </form>
    </div>

</div>

<script>
$(document).ready(function(){
    function loadStudents(class_id){
        $.ajax({
            url: 'fetch_students.php',
            method: 'GET',
            data: {class_id: class_id},
            success: function(response){
                $('#student_select').html(response);
                $('#hidden_class_id').val(class_id);
            }
        });
    }

    // Initial load (All students)
    loadStudents(0);

    // On class change
    $('#class_select').change(function(){
        var class_id = $(this).val();
        loadStudents(class_id);
    });
});
</script>

</body>
</html>

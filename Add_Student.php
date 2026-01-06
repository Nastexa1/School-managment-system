<?php
$message = "";
include 'db.php';
$query_classes = "SELECT * FROM classes";
$result_classes = mysqli_query($conn, $query_classes);

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $fullName = $_POST['fullName'];
    $Phone = $_POST['Phone'];
    $class = $_POST['class']; 
    $MotherName = $_POST["MotherName"];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    
   
    $sql = "INSERT INTO students (id, fullName, Phone, class, MotherName, address, gender, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'active')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $id, $fullName, $Phone, $class, $MotherName, $address, $gender);

    if ($stmt->execute()) {
        $message = "<p class='text-green-600 font-semibold bg-green-100 p-2 rounded'>Student added successfully!</p>";
    } else {
        $message = "<p class='text-red-600 font-semibold bg-red-100 p-2 rounded'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Registration</title>
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

    <div class="flex-1 ml-64 flex justify-center pt-10">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-5xl border border-gray-200">
            <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Registration Form - New Student</h1>

            <?php if($message != '') { echo "<div class='mb-6'>$message</div>"; } ?>

            <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <label class="block font-semibold">Student ID</label>
                    <input type="text" name="id" placeholder="Ex: 1255" class="w-full border-2 border-gray-300 py-3 px-4 rounded focus:border-blue-500 outline-none" required>
                    
                    <label class="block font-semibold">Full Name</label>
                    <input type="text" name="fullName" placeholder="Enter Full Name" class="w-full border-2 border-gray-300 py-3 px-4 rounded focus:border-blue-500 outline-none" required>
                    
                    <label class="block font-semibold">Phone Number</label>
                    <input type="text" name="Phone" placeholder="61XXXXXXX" class="w-full border-2 border-gray-300 py-3 px-4 rounded focus:border-blue-500 outline-none" required>
                    
                    <label class="block font-semibold">Mother Name</label>
                    <input type="text" name="MotherName" placeholder="Enter Mother Name" class="w-full border-2 border-gray-300 py-3 px-4 rounded focus:border-blue-500 outline-none" required>
                </div>

                <div class="space-y-4">
                    <label class="block font-semibold">Select Class</label>
                    <select name="class" class="w-full border-2 border-gray-300 py-3 px-4 rounded focus:border-blue-500 outline-none bg-white" required>
                        <option value="">-- Choose Class --</option>
                        <?php 
                        // Loop-ka soo saaraya fasallada database-ka ku jira
                        while($row = mysqli_fetch_assoc($result_classes)) {
                            echo "<option value='".$row['class_name']."'>".$row['class_name']."</option>";
                        }
                        ?>
                    </select>

                    <label class="block font-semibold">Address</label>
                    <input type="text" name="address" placeholder="Ex: Karan, Mogadishu" class="w-full border-2 border-gray-300 py-3 px-4 rounded focus:border-blue-500 outline-none" required>
                    
                    <label class="block font-semibold">Gender</label>
                    <select name="gender" class="w-full border-2 border-gray-300 py-3 px-4 rounded focus:border-blue-500 outline-none bg-white" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    <div class="pt-4">
                        <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-4 rounded-lg hover:bg-blue-700 font-bold text-lg shadow-lg transition">
                            Register Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
<?php
include 'db.php';

// Total Students
$total_students = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) AS total FROM students")
)['total'];

// Total Classes
$total_classes = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) AS total FROM classes")
)['total'];

// Attendance Today
$today = date('Y-m-d');
$present = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) AS total FROM attendance WHERE attendance_date='$today' AND status='present'")
)['total'];

$total_students_all = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) AS total FROM students")
)['total'];

$absent = $total_students_all - $present;

// Enrollment per month (Jan–Jun)
$enroll = [];
for($m=1;$m<=6;$m++){
  $enroll[] = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM students WHERE MONTH(created_at)=$m")
  )['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            
            <div class="-mt-10">
                <a href="logout.php" class="flex items-center space-x-4 bg-red-500/5 text-red-500 hover:bg-red-500 hover:text-white p-3 rounded-xl transition-all">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </div>
        </nav>
    </aside>

<!-- MAIN -->
<main class="flex-1 p-8 ml-[280px] bg-white">

<h1 class="text-3xl font-bold mb-8">
📊 School Management Dashboard
</h1>

<!-- CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

<div class="bg-white text-black p-6 rounded-xl shadow">
  <div class="flex justify-between items-center">
    <div>
      <p class="uppercase text-sm opacity-80">Total Students</p>
      <h2 class="text-3xl font-bold mt-2"><?php echo $total_students; ?></h2>
    </div>
  </div>
</div>

<div class="bg-white text-black p-6 rounded-xl shadow">
  <div class="flex justify-between items-center">
    <div>
      <p class="uppercase text-sm opacity-80">Total Classes</p>
      <h2 class="text-3xl font-bold mt-2"><?php echo $total_classes; ?></h2>
    </div>
  </div>
</div>

<div class="bg-white to-black text-black p-6 rounded-xl shadow">
  <div class="flex justify-between items-center">
    <div>
      <p class="uppercase text-sm opacity-80">Attendance Today</p>
      <h2 class="text-3xl font-bold mt-2"><?php echo $present; ?></h2>
    </div>
  </div>
</div>

</div>

<!-- CHARTS -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

<div class="bg-white p-6 rounded-xl shadow">
  <h2 class="font-semibold text-gray-700 mb-4">📈 Student Enrollment (Jan–Jun)</h2>
  <canvas id="barChart"></canvas>
</div>

<div class="bg-white p-6 rounded-xl shadow">
  <h2 class="font-semibold text-gray-700 mb-4">🥧 Attendance Today</h2>
  <canvas id="pieChart"></canvas>
</div>

</div>

</main>
</div>

<script>
// BAR CHART
new Chart(document.getElementById('barChart'),{
  type:'bar',
  data:{
    labels:['Jan','Feb','Mar','Apr','May','Jun'],
    datasets:[{
      label:'Students',
      data: <?php echo json_encode($enroll); ?>,
      backgroundColor:'#3B82F6'
    }]
  },
  options:{responsive:true,scales:{y:{beginAtZero:true}}}
});

// PIE CHART
new Chart(document.getElementById('pieChart'),{
  type:'pie',
  data:{
    labels:['Present','Absent'],
    datasets:[{
      data:[<?php echo $present; ?>,<?php echo $absent; ?>],
      backgroundColor:['#22C55E','#EF4444']
    }]
  },
  options:{responsive:true}
});
</script>

</body>
</html>

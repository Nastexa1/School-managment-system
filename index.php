<?php
$conn = mysqli_connect("localhost","root","123","school_management");
if(!$conn){
  die("Connection Failed: ".mysqli_connect_error());
}

// Total Students
$total_student_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$total_students = mysqli_fetch_assoc($total_student_result)['total'];

// Total Classes
$total_classes_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM classes");
$total_classes = mysqli_fetch_assoc($total_classes_result)['total'];

// Attendance Today
$today = date('Y-m-d');
$attendance_today_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM attendance WHERE attendance_date='$today' AND status='present'");
$attendance_today = mysqli_fetch_assoc($attendance_today_result)['total'];

// Attendance counts for Pie Chart
$present_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM attendance WHERE attendance_date='$today' AND status='present'"))['total'];
$absent_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM students"))['total'] - $present_count;

// Enrollment data for Bar Chart (example per month)
$enroll_data = [0,0,0,0,0,0]; // Jan-Jun
for($m=1;$m<=6;$m++){
    $month_str = str_pad($m,2,'0',STR_PAD_LEFT);
    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM students WHERE MONTH(created_at)='$month_str'"))['total'];
    $enroll_data[$m-1] = $count;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">

  <!-- Sidebar -->
  <div class="bg-gray-800 text-white w-64 flex flex-col">
    <div class="p-6 text-center text-xl font-bold border-b border-gray-700">
      Student Record
    </div>
    <nav class="flex-1 p-4 space-y-2">
      <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
      <a href="view_students.php" class="flex items-center p-2 rounded hover:bg-gray-700">🎓 Students</a>
      <a href="add_student.php" class="flex items-center p-2 rounded hover:bg-gray-700">➕ Add Student</a>
      <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏫 Classes</a>
      <a href="attendence.php" class="flex items-center p-2 rounded hover:bg-gray-700">✅ Attendance</a>
      <a href="grades.php" class="flex items-center p-2 rounded hover:bg-gray-700">📝 Grades</a>
      <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">🔓 Logout</a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-6 overflow-auto">
    <h1 class="text-3xl font-bold mb-6">Welcome to Dashboard</h1>

    <!-- Cards -->
    <div class="flex gap-6 mb-6">
      <div class="bg-blue-500 w-[340px] h-[110px] text-center pt-9 rounded text-white">
        <h1 class="font-semibold">Total Students</h1>
        <span class="font-bold text-lg"><?php echo $total_students;?></span>
      </div>
      <div class="bg-green-500 w-[340px] h-[110px] text-center pt-9 rounded text-white">
        <h1 class="font-semibold">Total Classes</h1>
        <span class="font-bold text-lg"><?php echo $total_classes; ?></span>
      </div>
      <div class="bg-black w-[340px] h-[110px] text-center pt-9 rounded text-white">
        <h1 class="font-semibold">Attendance Today</h1>
        <span class="font-bold text-lg"><?php echo $attendance_today; ?></span>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Bar Chart -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold text-lg mb-2">Student Enrollment (Jan-Jun)</h2>
        <canvas id="barChart"></canvas>
      </div>

      <!-- Pie Chart -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold text-lg mb-2">Attendance Distribution Today</h2>
        <canvas id="pieChart"></canvas>
      </div>
    </div>

  </div>
</div>

<script>
  // Bar Chart
  const ctxBar = document.getElementById('barChart').getContext('2d');
  const barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun'],
      datasets: [{
        label: 'Enrolled Students',
        data: <?php echo json_encode($enroll_data); ?>,
        backgroundColor: 'rgba(59, 130, 246, 0.7)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 1
      }]
    },
    options: { responsive:true, scales:{ y:{ beginAtZero:true } } }
  });

  // Pie Chart
  const ctxPie = document.getElementById('pieChart').getContext('2d');
  const pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: ['Present','Absent'],
      datasets: [{
        data: [<?php echo $present_count; ?>, <?php echo $absent_count; ?>],
        backgroundColor: ['#34D399','#F87171']
      }]
    },
    options: { responsive:true }
  });
</script>

</body>
</html>

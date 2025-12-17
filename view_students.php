<?php
$conn=mysqli_connect("localhost","root","123","school_management");
if(!$conn){
  die("connection is failed".mysqli_connect_error());
}
$sql="SELECT*FROM students";
$result=mysqli_query($conn,$sql)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
    <div class="bg-gray-800 fixed h-[100vh] text-white w-64 flex flex-col">
        <div class="p-6 text-center text-xl font-bold border-b border-gray-700">
            Student Record
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏠 Dashboard</a>
            <a href="view_students.php" class="flex items-center p-2 rounded hover:bg-gray-700">🎓 Students</a>
            <a href="add_student.php" class="flex items-center p-2 rounded hover:bg-gray-700">➕ Add Student</a>
            <a href="classes.php" class="flex items-center p-2 rounded hover:bg-gray-700">🏫 Classes</a>
            <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">📝 Grades</a>
            <a href="#" class="flex items-center p-2 rounded hover:bg-gray-700">✅ Attendance</a>
            <a href="logout.php" class="flex items-center p-2 rounded hover:bg-gray-700">🔓 Logout</a>
        </nav>
    </div>
    <!-- Sidebar End -->

    <!-- Main Content -->
    <div class="flex-1 px-10 pt-10 ml-64">

        <h1 class="text-2xl font-bold mb-6 text-center">Student List</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white  shadow-lg rounded-md overflow-hidden">
                <thead class="bg-gray-700 text-white text-sm">
                    <tr>
                        <th class="px-3 py-2 border">ID</th>
                        <th class="px-3 py-2 border">Name</th>
                        <th class="px-3 py-2 border">Mother Name</th>
                        <th class="px-3 py-2 border">Phone</th>
                        <th class="px-3 py-2 border">Class</th>
                        <th class="px-3 py-2 border">Address</th>
                        <th class="px-3 py-2 border">Gender</th>
                        <th class="px-3 py-2 border">Actions</th>
                    </tr>
                </thead>

                <tbody class="text-sm">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-3 py-2 border"><?php echo $row['id']; ?></td>
                            <td class="px-3 py-2 border"><?php echo $row['fullName']; ?></td>
                            <td class="px-3 py-2 border"><?php echo $row['MotherName']; ?></td>
                            <td class="px-3 py-2 border"><?php echo $row['Phone']; ?></td>
                            <td class="px-3 py-2 border"><?php echo $row['class']; ?></td>
                            <td class="px-3 py-2 border"><?php echo $row['address']; ?></td>
                            <td class="px-3 py-2 border"><?php echo $row['gender']; ?></td>

                            <td class="px-3 py-2 border flex gap-3 justify-center">

                                <!-- Edit Icon -->
                                <a href="edit_student.php?id=<?php echo $row['id']; ?>"
                                   class="text-green-600 hover:text-green-800" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                         d="M11 5H6a2 2 0 00-2 2v11a2 
                                         2 0 002 2h11a2 2 0 002-2v-5M18.5 
                                         2.5a2.121 2.121 0 113 3L12 15l-4 
                                         1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>

                                <!-- Delete Icon -->
                                <a href="delete_student.php?id=<?php echo $row['id']; ?>"
                                   onclick="return confirm('Delete this student?');"
                                   class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                         d="M19 7l-.867 12.142A2 2 0 0116.138 
                                         21H7.862a2 2 0 01-1.995-1.858L5 
                                         7m5 4v6m4-6v6M9 7h6m-7 0V5a2 
                                         2 0 012-2h3a2 2 0 012 2v2" />
                                    </svg>
                                </a>

                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>

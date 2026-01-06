<?php
include 'db.php';

if (!isset($_GET['email'])) {
    die("Email ma jiro!");
}

$email = $_GET['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    mysqli_query($conn,
        "UPDATE users SET password='$password' WHERE email='$email'"
    );

    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-lg w-96">
    <h2 class="text-2xl font-bold text-center mb-4">Reset Password</h2>

    <form method="POST" class="space-y-4">
        <input type="password" name="password"
               placeholder="Password cusub"
               class="w-full border p-3 rounded-xl"
               required>

        <button class="w-full bg-green-600 text-white p-3 rounded-xl">
            Save Password
        </button>
    </form>
</div>

</body>
</html>

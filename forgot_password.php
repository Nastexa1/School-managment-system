<?php
include 'db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) == 1) {
        header("Location: reset_password.php?email=$email");
        exit();
    } else {
        $error = "Email lama helin!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-lg w-96">
    <h2 class="text-2xl font-bold text-center mb-4">Forgot Password</h2>

    <?php if($error): ?>
      <p class="text-red-500 text-center mb-3"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <input type="email" name="email"
               placeholder="Geli Email"
               class="w-full border p-3 rounded-xl"
               required>

        <button class="w-full bg-blue-600 text-white p-3 rounded-xl">
            Continue
        </button>
    </form>
</div>

</body>
</html>

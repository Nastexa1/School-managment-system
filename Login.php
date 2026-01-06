<?php
session_start();            
include 'db.php';

$error = "";

$saved_username = isset($_COOKIE['user_login']) ? $_COOKIE['user_login'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $remember = isset($_POST['remember']);

    if (empty($username) || empty($password)) {
        $error = "Fadlan buuxi dhammaan meelaha bannaan!";
    } else {

        $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {

            $user = mysqli_fetch_assoc($result);

            if ($password === $user['password']) {

                if ($user['status'] == 'Active') {

                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['username']  = $user['username'];
                    $_SESSION['user_type'] = $user['user_type'];
                    $_SESSION['last_activity'] = time();

                    if ($remember) {
                        setcookie("user_login", $username, time() + (86400 * 10), "/");
                    } else {
                        setcookie("user_login", "", time() - 3600, "/");
                    }

                    header("Location: dashboard.php");
                    exit();

                } else {
                    $error = "Account-kaagu ma shaqaynayo!";
                }

            } else {
                $error = "Password-ka waa khalad!";
            }

        } else {
            $error = "Username lama helin!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 h-screen flex items-center justify-center p-4">

<div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md">

    <h1 class="text-3xl font-extrabold text-center mb-2">Welcome Back</h1>
    <p class="text-center text-gray-400 mb-6">Fadlan geli macluumaadkaaga</p>

    <?php if($error): ?>
        <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-sm text-center">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <input type="text" name="username"
               value="<?= $saved_username ?>"
               placeholder="Username"
               class="w-full p-4 rounded-xl border focus:ring-2 focus:ring-blue-500"
               required>

        <input type="password" name="password"
               placeholder="Password"
               class="w-full p-4 rounded-xl border focus:ring-2 focus:ring-blue-500"
               required>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" <?= $saved_username ? 'checked' : '' ?>>
                Remember Me
            </label>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700">
            Login
        </button>
           <p class="text-center text-sm text-gray-500">Don't have an account? <a class="text-red-600 font-bold hover:underline" href="signup.php">Signin</a></p>
           <p class="text-center mt-3 text-sm">
  <a href="forgot_password.php" class="text-blue-600 hover:underline">
    Forgot Password?
  </a>
</p>



    </form>
</div>

</body>
</html>

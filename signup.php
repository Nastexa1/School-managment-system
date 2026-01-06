<?php
include 'db.php';

$message = "";
$msg_class = "";

if (isset($_POST['register_btn'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password']; 
    $sex      = $_POST['sex'];
    $user_type = $_POST['user_type'];
    $status   = $_POST['status'];

    $img_name = $_FILES['profile_pic']['name'];
    $tmp_name = $_FILES['profile_pic']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($img_name);

    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if(mysqli_num_rows($check_user) > 0) {
        $message = "Username-kan waa la qaatay, fadlan mid kale dooro.";
        $msg_class = "bg-red-100 text-red-600";
    } else {
        if (move_uploaded_file($tmp_name, $target_file)) {
            $sql = "INSERT INTO users (full_name, email, username, password, phone, sex, profile_picture, user_type, status) 
                    VALUES ('$fullname', '$email', '$username', '$password', '$phone', '$sex', '$img_name', '$user_type', '$status')";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Hambalyo! User-ka si guul ah ayaa loo diiwaangeliyay.";
                $msg_class = "bg-green-100 text-green-600";
            } else {
                $message = "Khalad baa ka dhacay database-ka.";
                $msg_class = "bg-red-100 text-red-600";
            }
        } else {
            $message = "Sawirka lama upload-gareyn karo. Hubi folder-ka 'uploads'.";
            $msg_class = "bg-red-100 text-red-600";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Modern School System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-4xl mx-auto bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100">
        <div class="grid grid-cols-1 md:grid-cols-3">
            
            <div class="bg-slate-900 p-10 text-white flex flex-col justify-center">
                <div class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-user-plus text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold mb-4">Create Account</h2>
                <p class="text-slate-400 leading-relaxed">Ku dar user cusub nidaamka. Hubi in dhammaan xogtu ay sax tahay ka hor intaanad kaydin.</p>
                <div class="mt-10 space-y-4 text-sm">
                    <div class="flex items-center space-x-3 text-slate-300">
                        <i class="fa-solid fa-check-circle text-blue-500"></i>
                        <span>Auto-ID Generation</span>
                    </div>
                    <div class="flex items-center space-x-3 text-slate-300">
                        <i class="fa-solid fa-check-circle text-blue-500"></i>
                        <span>Secure Session Tracking</span>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 p-10 md:p-16">
                <?php if($message): ?>
                    <div class="<?= $msg_class ?> p-4 rounded-2xl mb-8 font-bold text-sm flex items-center shadow-sm">
                        <i class="fa-solid fa-circle-info mr-3"></i> <?= $message ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                            <input type="text" name="fullname" required class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 transition-all font-semibold" placeholder="Geli magaca oo buuxa">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 transition-all font-semibold" placeholder="example@mail.com">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                            <input type="text" name="phone" required class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 transition-all font-semibold" placeholder="+252...">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Username</label>
                            <input type="text" name="username" required class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 transition-all font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                            <input type="password" name="password" required class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 transition-all font-semibold" placeholder="••••••••">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Sex</label>
                            <select name="sex" class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 font-bold">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">User Type</label>
                            <select name="user_type" class="w-full bg-slate-50 border-2 border-slate-100 p-4 rounded-2xl outline-none focus:border-blue-500 font-bold text-blue-600">
                                <option value="Admin">Admin</option>
                                <option value="User">Standard User</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Profile Picture (Required)</label>
                        <div class="relative group">
                            <input type="file" name="profile_pic" required class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border-2 border-dashed border-slate-200 p-4 rounded-2xl">
                        </div>
                    </div>

                    <div class="flex items-center space-x-6 pt-4">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status:</span>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="Active" checked class="w-4 h-4 text-blue-600">
                            <span class="ml-2 text-sm font-bold text-slate-600">Active</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="Not Active" class="w-4 h-4 text-red-600">
                            <span class="ml-2 text-sm font-bold text-slate-600">Not Active</span>
                        </label>
                    </div>

                    <div class="pt-6 grid grid-cols-2 gap-4">
                        <button type="reset" class="p-5 rounded-2xl font-bold text-slate-400 hover:bg-slate-50 transition-all border-2 border-transparent">Reset Form</button>
                        <button type="submit" name="register_btn" class="bg-blue-600 text-white p-5 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all">Submit Registration</button>

                    </div>
                                <p class="text-center text-sm text-gray-500">Don't have an account? <a class="text-red-600 font-bold hover:underline" href="Login.php">Login</a></p>

                </form>
            </div>
        </div>
    </div>

</body>
</html>
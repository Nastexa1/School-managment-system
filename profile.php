<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' AND status='Active'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$profile_img = !empty($user['profile_picture']) && file_exists("uploads/".$user['profile_picture'])
    ? "uploads/".$user['profile_picture']
    : "https://ui-avatars.com/api/?name=".urlencode($user['full_name'])."&background=6366f1&color=fff&size=128";

$error = "";

if (isset($_POST['update_profile'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);

    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' AND id != '$user_id'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username-kan horey ayaa loo isticmaalay!";
    } else {
        mysqli_query($conn, "
            UPDATE users SET 
                full_name='$full_name',
                username='$username',
                email='$email',
                phone='$phone'
            WHERE id='$user_id'
        ");

        header("Location: profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Profile | <?= htmlspecialchars($user['full_name']) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    .modal { transition: opacity 0.25s ease; }
    body.modal-active { overflow-x: hidden; overflow-y: visible !important; }
</style>
</head>
<body class="bg-slate-50 min-h-screen">

<div class="flex">

<!-- ================= SIDEBAR ================= -->
<aside class="w-72 fixed bg-slate-900 h-[100vh] text-slate-300 flex flex-col shadow-2xl z-10">
    <div class="p-8 text-center border-b border-slate-800 flex">
        <div class="bg-blue-600 w-12 h-12 rounded-lg flex items-center justify-center mx-auto shadow-lg shadow-blue-500/50">
            <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
        </div>
        <span class="text-white text-xl font-bold tracking-tight mt-2">SCHOOL SYSTEM</span>
    </div>

    <nav class="flex-1 p-6 space-y-3">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-4">Main Menu</p>
        <a href="dashboard.php" class="flex items-center space-x-4 bg-blue-600/10 text-blue-400 p-3 rounded-xl border border-blue-600/20 transition-all">
            <i class="fa-solid fa-house w-5 text-center"></i><span class="font-medium">Dashboard</span>
        </a>
        <a href="profile.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
            <i class="fa-solid fa-user-circle w-5 text-center group-hover:text-blue-400"></i><span class="font-medium">Profile</span>
        </a>
        <a href="view_students.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
            <i class="fa-solid fa-user-graduate w-5 text-center group-hover:text-blue-400"></i><span class="font-medium">Students</span>
        </a>
        <a href="classes.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
            <i class="fa-solid fa-chalkboard-user w-5 text-center group-hover:text-blue-400"></i><span class="font-medium">Classes</span>
        </a>
        <a href="attendence.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
            <i class="fa-solid fa-calendar-check w-5 text-center group-hover:text-blue-400"></i><span class="font-medium">Attendance</span>
        </a>
        <a href="grades.php" class="flex items-center space-x-4 hover:bg-slate-800 hover:text-white p-3 rounded-xl transition-all group">
            <i class="fa-solid fa-file-invoice w-5 text-center group-hover:text-blue-400"></i><span class="font-medium">Grades</span>
        </a>

        <div class="pt-10">
            <a href="logout.php" class="flex items-center space-x-4 bg-red-500/5 text-red-500 hover:bg-red-500 hover:text-white p-3 rounded-xl transition-all">
                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i><span class="font-medium">Logout</span>
            </a>
        </div>
    </nav>
</aside>

<!-- ================= MAIN ================= -->
<main class="ml-72 flex flex-col">
    <nav class="bg-white border-b border-slate-200 px-8 py-4 sticky top-0 z-10 w-[100%]">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-bold text-slate-800">Account Settings</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-slate-500 font-medium">Welcome, <?= explode(' ', $user['full_name'])[0] ?></span>
                <img src="<?= $profile_img ?>" class="w-8 h-8 rounded-full border border-slate-200">
            </div>
        </div>
    </nav>

    <div class="p-8 max-w-5xl mx-auto w-full space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="relative">
                    <img src="<?= $profile_img ?>" class="w-32 h-32 rounded-[2.5rem] object-cover ring-8 ring-slate-50 shadow-xl">
                    <span class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></span>
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-extrabold text-slate-900"><?= htmlspecialchars($user['full_name']) ?></h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold uppercase"><?= $user['user_type'] ?></span>
                    </div>
                </div>
            </div>
            <button onclick="toggleModal()" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                Edit Profile
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Personal Information</h3>
                        <i class="fa-solid fa-user text-slate-300"></i>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Email Address</label>
                            <p class="text-slate-700 font-semibold"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Phone Number</label>
                            <p class="text-slate-700 font-semibold"><?= htmlspecialchars($user['phone']) ?></p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Username</label>
                            <p class="text-indigo-600 font-bold">@<?= htmlspecialchars($user['username']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- ================= EDIT PROFILE MODAL ================= -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal()"></div>

    <div class="relative bg-white w-full max-w-md m-4 rounded-3xl shadow-2xl p-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-slate-800">Edit Profile</h3>
            <button onclick="toggleModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>

        <?php if($error): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-xs font-bold border border-red-100 text-center"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="toggleModal()" class="flex-1 px-4 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Cancel</button>
                <button type="submit" name="update_profile" class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleModal() {
    const modal = document.getElementById('editModal');
    modal.classList.toggle('hidden');
}
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-white text-slate-900">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="bg-blue-600 p-2 rounded-lg text-white">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight">SCHOOL SYSTEM</span>
            </div>
            <div class="hidden md:flex space-x-8 font-semibold text-sm text-slate-600 uppercase tracking-wider">
                <a href="#home" class="hover:text-blue-600 transition">Home</a>
                <a href="#about" class="hover:text-blue-600 transition">About</a>
                <a href="#services" class="hover:text-blue-600 transition">Services</a>
            </div>
            <a href="login.php" class="bg-blue-600 text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                Portal Login
            </a>
        </div>
    </nav>

    <section id="home" class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">Education Management</span>
                <h1 class="text-5xl md:text-6xl font-extrabold mt-6 leading-tight">Empowering the Future of <span class="text-blue-600">Learning.</span></h1>
                <p class="text-slate-500 mt-6 text-lg leading-relaxed">Nidaam casri ah oo loogu talagalay maamulka dugsiyada, la socodka ardayda, iyo tayeynta waxbarashada dalka.</p>
                <div class="mt-10 flex space-x-4">
                    <a href="signup.php" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition">Get Started</a>
                    <a href="#about" class="border border-slate-200 px-8 py-4 rounded-2xl font-bold hover:bg-slate-50 transition">Learn More</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -z-10 bg-blue-100 w-full h-full rounded-3xl rotate-3"></div>
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Students" class="rounded-3xl shadow-2xl">
            </div>
        </div>
    </section>

    <section id="about" class="py-20 bg-slate-50 px-6">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-3xl font-bold italic mb-6">"Knowledge is Power"</h2>
            <p class="text-xl text-slate-600 leading-relaxed max-w-3xl mx-auto">
                Dugsigeena waxaa la aasaasay 2010, ujeedkeenuna waa inaan bixino waxbarasho tayo leh oo ku dhisan tignoolajiyad casri ah si aan u soo saarno hoggaamiyayaasha mustaqbalka.
            </p>
        </div>
    </section>

    <section id="services" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold">Our Core Features</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto mt-4"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Attendance Tracking</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Si fudud ula soco imaanshaha iyo maqnaanshaha ardayda maalin kasta.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Grade Management</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Diiwaangeli buundooyinka imtixaanka adoo isticmaalaya nidaam sugan.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-teal-600 group-hover:text-white transition">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">User Roles</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Maamulayaasha iyo macalimiinta waxay leeyihiin awoodo kala duwan.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center border-t border-slate-800 pt-8">
            <div class="mb-6 md:mb-0">
                <span class="text-white text-lg font-bold uppercase tracking-widest italic">School Management System</span>
                <p class="text-xs mt-2">&copy; 2025 All Rights Reserved. Built by You.</p>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>
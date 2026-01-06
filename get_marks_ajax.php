<?php
include 'db.php';

if(isset($_POST['student_id'])){
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    
    $sql = "SELECT g.*, s.fullName FROM grades g 
            JOIN students s ON g.student_id = s.id 
            WHERE g.student_id = '$student_id' LIMIT 1";
    
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        $subject_names = [
            1 => "Mathematics",
            2 => "English",
            3 => "Science",
            4 => "History",
            5 => "Geography",
            6 => "Somali",
            7 => "Islamic",
            8 => "ICT"
        ];

        ?>
        <div class="w-full animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-800 underline decoration-blue-500 underline-offset-8">
                    <?= $row['fullName'] ?>'s Performance
                </h2>
                <span class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-bold">
                    Grade: <?= $row['grade'] ?>
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <?php for($i=1; $i<=8; $i++): ?>
                <div class="bg-slate-50 p-5 rounded-3xl border border-slate-100 hover:border-blue-200 transition-all">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">
                        <?= $subject_names[$i] ?>
                    </p>
                    <p class="text-2xl font-black text-slate-700"><?= $row['subject'.$i] ?></p>
                </div>
                <?php endfor; ?>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4">
                <div class="bg-blue-50 p-6 rounded-[2rem] text-center border border-blue-100">
                    <p class="text-xs font-bold text-blue-400 uppercase">Total Marks</p>
                    <p class="text-3xl font-black text-blue-700"><?= $row['total'] ?></p>
                </div>
                <div class="bg-green-50 p-6 rounded-[2rem] text-center border border-green-100">
                    <p class="text-xs font-bold text-green-400 uppercase">Average Percentage</p>
                    <p class="text-3xl font-black text-green-700"><?= number_format($row['average'], 1) ?>%</p>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo '<div class="text-center text-red-500 font-bold p-10">Ardaygaan darajooyin looma hayo!</div>';
    }
}
?>
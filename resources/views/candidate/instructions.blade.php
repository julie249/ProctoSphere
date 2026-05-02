<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Instructions | ProctoSphere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">

<div class="max-w-4xl mx-auto py-10 px-6">
    <div class="bg-white rounded-3xl shadow-xl p-8">

        <h1 class="text-3xl font-bold text-slate-800 mb-2">
            Exam Instructions
        </h1>

        <p class="text-slate-500 mb-6">
            Please read all rules carefully before starting the exam.
        </p>

        <div class="space-y-4 text-slate-700">
            <p>✅ Keep your camera enabled throughout the exam.</p>
            <p>✅ Stay in fullscreen mode.</p>
            <p>❌ Do not switch tabs or open another window.</p>
            <p>❌ Copy, paste, and right-click are disabled.</p>
            <p>⚠️ Every suspicious activity will be recorded.</p>
            <p>⚠️ Too many violations may auto-submit your exam.</p>
        </div>

        <div class="mt-8 bg-yellow-100 text-yellow-800 p-4 rounded-xl">
            Your proctoring activity will be monitored for fair candidate shortlisting.
        </div>

        <!-- 🔥 Webcam Preview -->
        <div class="mt-8">
            <div class="mb-6 text-center">
                <video id="webcam"
                    class="w-full max-w-md mx-auto rounded-xl border bg-black">
                </video>
            </div>

            <div class="flex justify-between items-center">
                <a href="/dashboard"
                   class="px-6 py-3 bg-slate-700 text-white rounded-xl hover:bg-slate-800">
                    Back
                </a>

                <button id="startBtn"
                   class="px-6 py-3 bg-gray-400 text-white rounded-xl cursor-not-allowed"
                   disabled>
                    Start Exam
                </button>
            </div>
        </div>

    </div>
</div>

<!-- 🔥 Webcam Script -->
<script>
let video = document.getElementById("webcam");
let startBtn = document.getElementById("startBtn");

navigator.mediaDevices.getUserMedia({ video: true })
.then(function(stream) {
    video.srcObject = stream;
    video.play();

    // Enable button
    startBtn.disabled = false;
    startBtn.classList.remove("bg-gray-400", "cursor-not-allowed");
    startBtn.classList.add("bg-indigo-600");

})
.catch(function() {
    alert("Camera access is required to start exam.");
});

// Start exam
startBtn.addEventListener("click", function() {
    window.location.href = "{{ route('candidate.exam.start.direct', $exam->id) }}";
});
</script>

</body>
</html>
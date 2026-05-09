<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Instructions | ProctoSphere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-6">

    <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-200">

        <h1 class="text-3xl font-bold text-slate-800 mb-2">
            Exam Instructions
        </h1>

        <p class="text-slate-500 mb-6">
            Please read all rules carefully before starting the exam.
        </p>

        <div class="grid md:grid-cols-4 gap-4 mb-8">
            <div class="bg-indigo-50 p-4 rounded-xl">
                <p class="text-sm text-slate-500">Exam</p>
                <p class="font-bold text-slate-800">{{ $exam->title }}</p>
            </div>

            <div class="bg-green-50 p-4 rounded-xl">
                <p class="text-sm text-slate-500">Duration</p>
                <p class="font-bold text-slate-800">{{ $exam->duration }} mins</p>
            </div>

            <div class="bg-blue-50 p-4 rounded-xl">
                <p class="text-sm text-slate-500">Total Marks</p>
                <p class="font-bold text-slate-800">{{ $exam->total_marks }}</p>
            </div>

            <div class="bg-red-50 p-4 rounded-xl">
                <p class="text-sm text-slate-500">Negative Marks</p>
                <p class="font-bold text-slate-800">{{ $exam->negative_marks }}</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">

            <div>
                <h2 class="text-xl font-bold text-slate-800 mb-4">
                    Rules & Proctoring Policy
                </h2>

                <div class="space-y-4 text-slate-700">
                    <p>✅ Keep your camera enabled throughout the exam.</p>
                    <p>✅ Stay in fullscreen mode during the exam.</p>
                    <p>❌ Do not switch tabs or open another window.</p>
                    <p>❌ Copy, paste, and right-click are disabled.</p>
                    <p>⚠️ Every suspicious activity will be recorded.</p>
                    <p>⚠️ Too many violations may auto-submit your exam.</p>
                </div>

                <div class="mt-6 bg-yellow-100 text-yellow-800 p-4 rounded-xl">
                    Your proctoring activity will be monitored for fair candidate shortlisting.
                </div>

                <div class="mt-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-200">
                    Multiple attempts are not allowed. Once submitted, your result will be final.
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-800 mb-4 text-center">
                    Webcam Verification
                </h2>

                <video id="webcam"
                       autoplay
                       playsinline
                       muted
                       class="w-full max-w-md mx-auto rounded-xl border bg-black shadow">
                </video>

                <p id="cameraStatus"
                   class="text-center text-sm text-slate-500 mt-4">
                    Waiting for camera permission...
                </p>

                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('candidate.hackathons') }}"
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

</div>

<script>
    let video = document.getElementById("webcam");
    let startBtn = document.getElementById("startBtn");
    let cameraStatus = document.getElementById("cameraStatus");
    let cameraStream = null;

    function disableStartButton() {
        startBtn.disabled = true;
        startBtn.classList.remove("bg-indigo-600", "hover:bg-indigo-700");
        startBtn.classList.add("bg-gray-400", "cursor-not-allowed");
    }

    function enableStartButton() {
        startBtn.disabled = false;
        startBtn.classList.remove("bg-gray-400", "cursor-not-allowed");
        startBtn.classList.add("bg-indigo-600", "hover:bg-indigo-700");
    }

    async function startCamera() {
        disableStartButton();

        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            });

            video.srcObject = cameraStream;
            await video.play();

            cameraStatus.innerText = "Checking camera visibility...";
            cameraStatus.classList.remove("text-slate-500", "text-red-600", "text-green-600");
            cameraStatus.classList.add("text-yellow-600");

            setTimeout(checkCameraVisibility, 2000);

        } catch (error) {
            cameraStatus.innerText = "❌ Camera access is required to start the exam.";
            cameraStatus.classList.remove("text-slate-500", "text-yellow-600", "text-green-600");
            cameraStatus.classList.add("text-red-600");
            disableStartButton();
        }
    }

    function checkCameraVisibility() {
        if (!video.videoWidth || !video.videoHeight) {
            cameraStatus.innerText = "❌ Camera feed is not available. Please check your webcam.";
            cameraStatus.classList.remove("text-slate-500", "text-yellow-600", "text-green-600");
            cameraStatus.classList.add("text-red-600");
            disableStartButton();
            return;
        }

        let canvas = document.createElement("canvas");
        let context = canvas.getContext("2d");

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        let frame = context.getImageData(0, 0, canvas.width, canvas.height);
        let data = frame.data;

        let totalBrightness = 0;

        for (let i = 0; i < data.length; i += 4) {
            let r = data[i];
            let g = data[i + 1];
            let b = data[i + 2];

            totalBrightness += (r + g + b) / 3;
        }

        let avgBrightness = totalBrightness / (data.length / 4);

        if (avgBrightness < 25) {
            cameraStatus.innerText = "❌ Camera is too dark or shutter is closed. Please open the camera shutter and improve lighting.";
            cameraStatus.classList.remove("text-slate-500", "text-yellow-600", "text-green-600");
            cameraStatus.classList.add("text-red-600");
            disableStartButton();

            setTimeout(checkCameraVisibility, 2000);
        } else {
            cameraStatus.innerText = "✅ Camera verified successfully.";
            cameraStatus.classList.remove("text-slate-500", "text-yellow-600", "text-red-600");
            cameraStatus.classList.add("text-green-600");
            enableStartButton();
        }
    }

    startCamera();

    startBtn.addEventListener("click", function () {
        if (!startBtn.disabled) {
            window.location.href = "{{ route('candidate.exam.start', $exam->id) }}";
        }
    });
</script>

</body>
</html>
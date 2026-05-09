<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $exam->title }} | ProctoSphere</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

<div id="warningBar"
     class="fixed top-0 left-0 w-full bg-red-600 text-white text-center py-3 z-50 font-bold hidden">
    Violation Detected! Total Violations:
    <span id="warningCount">0</span>
</div>

<div class="fixed bottom-4 right-4 bg-white p-3 rounded-2xl shadow-xl border z-50">
    <video id="examWebcam"
           autoplay
           playsinline
           muted
           class="w-40 h-28 rounded-xl bg-black object-cover">
    </video>

    <p id="examCameraStatus" class="text-xs text-center mt-2 text-green-600">
        Camera Starting...
    </p>
</div>

<div class="max-w-5xl mx-auto py-16 px-6">

    <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-200">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                {{ $exam->title }}
            </h1>

            <p class="text-slate-500 mt-2">
                {{ $exam->hackathon->title ?? 'Hackathon Exam' }}
            </p>

            <div class="mt-4 grid md:grid-cols-4 gap-4">
                <div class="bg-indigo-50 p-4 rounded-xl">
                    <p class="text-sm text-slate-500">Duration</p>
                    <p class="font-bold">{{ $exam->duration }} mins</p>
                </div>

                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-sm text-slate-500">Total Marks</p>
                    <p class="font-bold">{{ $exam->total_marks }}</p>
                </div>

                <div class="bg-green-50 p-4 rounded-xl">
                    <p class="text-sm text-slate-500">Passing Marks</p>
                    <p class="font-bold">{{ $exam->passing_marks }}</p>
                </div>

                <div class="bg-red-50 p-4 rounded-xl">
                    <p class="text-sm text-slate-500">Time Left</p>
                    <p id="timer" class="font-bold text-red-600">
                        {{ $exam->duration }}:00
                    </p>
                </div>
            </div>
        </div>

        <form id="examForm"
              method="POST"
              action="{{ route('candidate.exam.submit', $exam->id) }}">

            @csrf

            <input type="hidden" name="violations" id="violationsInput" value="0">

            @forelse($questions as $index => $question)

                <div class="mb-8 p-6 rounded-2xl border bg-slate-50">

                    <h2 class="text-lg font-bold text-slate-800 mb-4">
                        Q{{ $index + 1 }}. {{ $question->question }}
                    </h2>

                    <div class="space-y-3">

                        <label class="block bg-white p-3 rounded-xl border cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="A" class="mr-2">
                            {{ $question->option_a }}
                        </label>

                        <label class="block bg-white p-3 rounded-xl border cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="B" class="mr-2">
                            {{ $question->option_b }}
                        </label>

                        <label class="block bg-white p-3 rounded-xl border cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="C" class="mr-2">
                            {{ $question->option_c }}
                        </label>

                        <label class="block bg-white p-3 rounded-xl border cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="D" class="mr-2">
                            {{ $question->option_d }}
                        </label>

                    </div>

                </div>

            @empty

                <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl">
                    No questions available for this exam.
                </div>

            @endforelse

            <div class="text-center">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold">
                    Submit Exam
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    let warnings = 0;
    let maxWarnings = {{ $exam->max_warnings ?? 5 }};
    let duration = {{ $exam->duration }} * 60;
    let examCameraStream = null;
    let cameraViolationGiven = false;

    const warningBar = document.getElementById('warningBar');
    const warningCount = document.getElementById('warningCount');
    const violationsInput = document.getElementById('violationsInput');
    const examForm = document.getElementById('examForm');
    const timerElement = document.getElementById('timer');

    const examVideo = document.getElementById("examWebcam");
    const examCameraStatus = document.getElementById("examCameraStatus");

    function increaseWarning(reason) {
        warnings++;

        warningBar.classList.remove('hidden');
        warningCount.innerText = warnings;
        violationsInput.value = warnings;

        saveProctorLog(reason);

        alert("Violation Detected: " + reason);

        if (warnings >= maxWarnings) {
            alert("Maximum violations reached. Exam will auto-submit.");
            examForm.submit();
        }
    }

    function captureSnapshot() {
        if (!examVideo) {
            console.log("No video element found");
            return null;
        }

        if (!examVideo.videoWidth || !examVideo.videoHeight) {
            console.log("Video not ready yet", examVideo.videoWidth, examVideo.videoHeight);
            return null;
        }

        let canvas = document.createElement("canvas");
        canvas.width = examVideo.videoWidth;
        canvas.height = examVideo.videoHeight;

        let context = canvas.getContext("2d");
        context.drawImage(examVideo, 0, 0, canvas.width, canvas.height);

        let imageData = canvas.toDataURL("image/png");

        console.log("Snapshot captured:", imageData.substring(0, 30));

        return imageData;
    }

    function saveProctorLog(reason) {
        let snapshot = captureSnapshot();

        console.log("Snapshot before sending:", snapshot ? "YES" : "NO");

        fetch("{{ route('proctor.log') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                exam_id: "{{ $exam->id }}",
                event_type: reason,
                details: "Violation detected during exam",
                snapshot: snapshot
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log("Proctor log saved:", data);
        })
        .catch(error => {
            console.error("Proctor log error:", error);
        });
    }

    function updateTimer() {
        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;

        timerElement.innerText =
            minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);

        if (duration <= 0) {
            alert("Time is up! Exam auto-submitted.");
            examForm.submit();
        }

        duration--;
    }

    setInterval(updateTimer, 1000);

    async function startExamCamera() {
        try {
            examCameraStream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            });

            examVideo.srcObject = examCameraStream;
            await examVideo.play();

            examCameraStatus.innerText = "Camera Active";
            examCameraStatus.classList.remove("text-red-600");
            examCameraStatus.classList.add("text-green-600");

            monitorCameraTrack();

            setTimeout(function () {
                console.log("Camera ready:", examVideo.videoWidth, examVideo.videoHeight);
            }, 2000);

        } catch (error) {
            examCameraStatus.innerText = "Camera Off";
            examCameraStatus.classList.remove("text-green-600");
            examCameraStatus.classList.add("text-red-600");

            if (!cameraViolationGiven) {
                cameraViolationGiven = true;
                increaseWarning("Camera turned off or blocked");
            }
        }
    }

    function monitorCameraTrack() {
        if (!examCameraStream) {
            return;
        }

        const videoTrack = examCameraStream.getVideoTracks()[0];

        if (videoTrack) {
            videoTrack.onended = function () {
                examCameraStatus.innerText = "Camera Off";
                examCameraStatus.classList.remove("text-green-600");
                examCameraStatus.classList.add("text-red-600");

                if (!cameraViolationGiven) {
                    cameraViolationGiven = true;
                    increaseWarning("Camera stopped during exam");
                }
            };

            videoTrack.onmute = function () {
                examCameraStatus.innerText = "Camera Blocked";
                examCameraStatus.classList.remove("text-green-600");
                examCameraStatus.classList.add("text-red-600");

                if (!cameraViolationGiven) {
                    cameraViolationGiven = true;
                    increaseWarning("Camera blocked during exam");
                }
            };
        }
    }

    startExamCamera();

    async function enterFullscreen() {
        try {
            if (document.documentElement.requestFullscreen) {
                await document.documentElement.requestFullscreen();
            }
        } catch (error) {
            console.log("Fullscreen request failed");
        }
    }

    enterFullscreen();

    document.addEventListener("fullscreenchange", function () {
        if (!document.fullscreenElement) {
            increaseWarning("Exited fullscreen mode");
        }
    });

    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            increaseWarning("Tab switched");
        }
    });

    document.addEventListener("copy", function (e) {
        e.preventDefault();
        increaseWarning("Copy action blocked");
    });

    document.addEventListener("paste", function (e) {
        e.preventDefault();
        increaseWarning("Paste action blocked");
    });

    document.addEventListener("contextmenu", function (e) {
        e.preventDefault();
        increaseWarning("Right click blocked");
    });

    document.addEventListener("keydown", function (e) {
        if (
            e.key === "F12" ||
            (e.ctrlKey && e.shiftKey && e.key === "I") ||
            (e.ctrlKey && e.shiftKey && e.key === "J") ||
            (e.ctrlKey && e.key === "U")
        ) {
            e.preventDefault();
            increaseWarning("Restricted shortcut used");
        }
    });
</script>

</body>
</html>
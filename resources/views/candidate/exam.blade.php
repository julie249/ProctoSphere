<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $exam->title }} | ProctoSphere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="min-h-screen">
    <header class="bg-slate-900 text-white px-8 py-5 flex justify-between items-center sticky top-0 z-50">
        <div>
            <h1 class="text-2xl font-bold">ProctoSphere</h1>
            <p class="text-slate-300 text-sm">{{ $exam->title }}</p>
        </div>

        <div class="bg-red-600 px-5 py-2 rounded-xl font-bold">
            Time Left: <span id="timer"></span>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-6">
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-2xl font-bold text-slate-800">{{ $exam->title }}</h2>
            <p class="text-slate-500 mt-2">
                Answer all questions carefully. Tab switching, copy/paste, right-click and fullscreen exit will be recorded.
            </p>
        </div>

        <form id="examForm" method="POST" action="{{ route('candidate.exam.submit', $exam->id) }}">
            @csrf

            @foreach($questions as $index => $question)
                <div class="bg-white rounded-2xl shadow p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">
                        Q{{ $index + 1 }}. {{ $question->question }}
                    </h3>

                    <div class="space-y-3">
                        <label class="block border rounded-xl p-4 hover:bg-indigo-50 cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="a" class="mr-2">
                            {{ $question->option_a }}
                        </label>

                        <label class="block border rounded-xl p-4 hover:bg-indigo-50 cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="b" class="mr-2">
                            {{ $question->option_b }}
                        </label>

                        <label class="block border rounded-xl p-4 hover:bg-indigo-50 cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="c" class="mr-2">
                            {{ $question->option_c }}
                        </label>

                        <label class="block border rounded-xl p-4 hover:bg-indigo-50 cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="d" class="mr-2">
                            {{ $question->option_d }}
                        </label>
                    </div>
                </div>
            @endforeach

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700">
                Submit Exam
            </button>
        </form>
    </main>
</div>

<script>
let timeLeft = {{ $exam->duration }} * 60;
let warnings = 0;
const maxWarnings = {{ $exam->max_warnings }};

let timer = setInterval(function () {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    document.getElementById("timer").innerHTML =
        minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

    if (timeLeft <= 0) {
        clearInterval(timer);
        document.getElementById("examForm").submit();
    }

    timeLeft--;
}, 1000);

function showWarning(reason) {
    warnings++;

    fetch("{{ route('proctor.log') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            exam_id: {{ $exam->id }},
            event_type: reason,
            details: reason
        })
    });

    alert("Warning " + warnings + "/" + maxWarnings + ": " + reason);

    if (warnings >= maxWarnings) {
        alert("Too many violations. Exam will be submitted.");
        document.getElementById("examForm").submit();
    }
}

document.addEventListener("visibilitychange", function () {
    if (document.hidden) showWarning("tab_switch");
});

document.addEventListener("contextmenu", function (e) {
    e.preventDefault();
    showWarning("right_click");
});

document.addEventListener("copy", function (e) {
    e.preventDefault();
    showWarning("copy_attempt");
});

document.addEventListener("paste", function (e) {
    e.preventDefault();
    showWarning("paste_attempt");
});

document.addEventListener("fullscreenchange", function () {
    if (!document.fullscreenElement) showWarning("fullscreen_exit");
});

window.onload = function () {
    document.documentElement.requestFullscreen().catch(function () {
        showWarning("fullscreen_permission_denied");
    });
};
</script>

</body>
</html>
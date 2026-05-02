<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result | ProctoSphere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-2xl rounded-3xl p-10 w-full max-w-xl text-center">

    <h1 class="text-3xl font-bold text-slate-800 mb-4">
        Exam Result
    </h1>

    <p class="text-slate-500 mb-6">
        Your performance summary
    </p>

    <!-- Score -->
    <div class="text-6xl font-bold text-indigo-600 mb-4">
        {{ $attempt->score }}
    </div>

    <p class="text-slate-600 mb-2">
        Out of {{ $attempt->total_questions }} questions
    </p>

    <!-- 🔥 Violations -->
    <p class="text-red-500 font-semibold mb-6">
        Violations: {{ $attempt->violations }}
    </p>

    <!-- Status -->
    @if($attempt->status == 'shortlisted')
        <span class="px-6 py-3 bg-green-100 text-green-700 font-bold rounded-full">
            ✅ Shortlisted
        </span>
    @else
        <span class="px-6 py-3 bg-red-100 text-red-700 font-bold rounded-full">
            ❌ Rejected
        </span>
    @endif

    <div class="mt-8">
        <a href="/dashboard"
           class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700">
            Go to Dashboard
        </a>
    </div>

</div>

</body>
</html>
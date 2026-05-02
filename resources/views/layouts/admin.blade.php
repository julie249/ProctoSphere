<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ProctoSphere Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">
    <aside class="w-64 bg-slate-900 text-white p-6">
        <h1 class="text-2xl font-bold mb-8">ProctoSphere</h1>

        <nav class="space-y-3">
            <a href="/admin/dashboard" class="block px-4 py-2 rounded-lg hover:bg-slate-700">Dashboard</a>
            <a href="/admin/leaderboard" class="block px-4 py-2 rounded-lg hover:bg-slate-700">
    Leaderboard
</a>
            <a href="/admin/exams" class="block px-4 py-2 rounded-lg hover:bg-slate-700">Exams</a>
            <a href="/admin/questions" class="block px-4 py-2 rounded-lg hover:bg-slate-700">Questions</a>
            <a href="/admin/attempts" class="block px-4 py-2 rounded-lg hover:bg-slate-700">Results</a>
        </nav>
    </aside>

    <main class="flex-1">
        <header class="bg-white shadow px-8 py-4 flex justify-between">
            <h2 class="text-xl font-semibold text-slate-800">@yield('title')</h2>
            <span class="text-slate-600">Admin Panel</span>
        </header>

        <section class="p-8">
            @yield('content')
        </section>
    </main>
</div>

</body>
</html>
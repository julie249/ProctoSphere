<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProctoSphere Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-slate-900 text-white flex flex-col shadow-2xl">

        <!-- Logo -->
        <div class="p-6 border-b border-slate-800">

            <h1 class="text-3xl font-bold text-indigo-400">
                ProctoSphere
            </h1>

            <p class="text-slate-400 text-sm mt-1">
                Admin Control Panel
            </p>

        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-6 space-y-3 overflow-y-auto">

            <a href="{{ url('/admin/dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                <span>📊</span>
                <span>Dashboard</span>

            </a>

            <a href="{{ url('/admin/hackathons') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                <span>🌍</span>
                <span>Hackathons</span>

            </a>

            <a href="{{ url('/admin/exams') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                <span>📝</span>
                <span>Exams</span>

            </a>

            <a href="{{ url('/admin/questions') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                <span>❓</span>
                <span>Questions</span>

            </a>
            

            <a href="{{ route('admin.attempts') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                <span>👨‍🎓</span>
                <span>Attempts</span>

            </a>

            <a href="{{ route('admin.leaderboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                <span>🏆</span>
                <span>Leaderboard</span>

            </a>

            <!-- Fixed Proctor Logs -->
            <a href="{{ route('admin.attempts') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition">

                <span>🚨</span>
                <span>Proctor Logs</span>

            </a>
            <a href="{{ route('admin.registrations.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition
   {{ request()->routeIs('admin.registrations.*') ? 'bg-slate-800 text-white' : '' }}">

    <span>🧾</span>
    <span>Registrations</span>

</a>
<a href="{{ route('admin.tokens.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition
   {{ request()->routeIs('admin.tokens.*') ? 'bg-slate-800 text-white' : '' }}">

    <span>🔑</span>
    <span>Exam Tokens</span>

</a>

           <a href="{{ route('admin.analytics') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition
   {{ request()->routeIs('admin.analytics') ? 'bg-slate-800 text-white' : '' }}">

    <span>📈</span>
    <span>Analytics</span>

</a>

        </nav>

        <!-- Footer -->
        <div class="p-6 border-t border-slate-800">

            <div class="mb-4">

                <p class="text-sm text-slate-400">
                    Logged in as
                </p>

                <p class="font-semibold">
                    {{ auth()->user()->name ?? 'Admin' }}
                </p>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 transition py-3 rounded-xl font-semibold">

                    Logout

                </button>
            </form>

        </div>

    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="bg-white shadow px-8 py-5 flex justify-between items-center">

            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    @yield('title')
                </h2>

                <p class="text-slate-500 text-sm mt-1">
                    ProctoSphere Administration
                </p>
            </div>

            <div class="flex items-center gap-4">

                <div class="text-right">
                    <p class="font-semibold text-slate-700">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p>

                    <p class="text-sm text-slate-500">
                        Administrator
                    </p>
                </div>

                <div class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

            </div>

        </header>

        <!-- Page Content -->
        <section class="p-8 flex-1">

            @if(session('success'))

                <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-2xl">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))

                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-2xl">

                    {{ session('error') }}

                </div>

            @endif

            @yield('content')

        </section>

    </main>

</div>

</body>
</html>
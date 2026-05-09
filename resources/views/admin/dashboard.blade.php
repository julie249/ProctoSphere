@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-800">
        Admin Dashboard
    </h1>

    <p class="text-slate-500 mt-2">
        Monitor exams, hackathons, candidates, and proctoring activities.
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    <!-- Total Hackathons -->
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6 rounded-3xl shadow-xl text-white">
        <h3 class="text-lg font-medium opacity-90">
            Total Hackathons
        </h3>

        <p class="text-4xl font-bold mt-3">
            {{ \App\Models\Hackathon::count() }}
        </p>
    </div>

    <!-- Total Exams -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-3xl shadow-xl text-white">
        <h3 class="text-lg font-medium opacity-90">
            Total Exams
        </h3>

        <p class="text-4xl font-bold mt-3">
            {{ \App\Models\Exam::count() }}
        </p>
    </div>

    <!-- Total Attempts -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-3xl shadow-xl text-white">
        <h3 class="text-lg font-medium opacity-90">
            Total Attempts
        </h3>

        <p class="text-4xl font-bold mt-3">
            {{ \App\Models\ExamAttempt::count() }}
        </p>
    </div>

    <!-- Total Violations -->
    <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-3xl shadow-xl text-white">
        <h3 class="text-lg font-medium opacity-90">
            Total Violations
        </h3>

        <p class="text-4xl font-bold mt-3">
            {{ \App\Models\ProctorLog::count() }}
        </p>
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

    <!-- Shortlisted -->
    <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-200">
        <h3 class="text-slate-500 text-lg">
            Shortlisted Candidates
        </h3>

        <p class="text-4xl font-bold text-green-600 mt-3">
            {{ \App\Models\ExamAttempt::where('status','shortlisted')->count() }}
        </p>
    </div>

    <!-- Rejected -->
    <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-200">
        <h3 class="text-slate-500 text-lg">
            Rejected Candidates
        </h3>

        <p class="text-4xl font-bold text-red-600 mt-3">
            {{ \App\Models\ExamAttempt::where('status','rejected')->count() }}
        </p>
    </div>

    <!-- High Risk Attempts -->
    <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-200">
        <h3 class="text-slate-500 text-lg">
            High Risk Attempts
        </h3>

        <p class="text-4xl font-bold text-yellow-500 mt-3">
            {{ \App\Models\ExamAttempt::where('violations', '>=', 3)->count() }}
        </p>
    </div>

</div>

<div class="mt-10">

    <h2 class="text-2xl font-bold text-slate-800 mb-6">
        Quick Actions
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <a href="{{ route('admin.exams.index') }}"
           class="bg-white hover:shadow-2xl transition p-6 rounded-3xl border border-slate-200">

            <h3 class="text-xl font-bold text-slate-800">
                Manage Exams
            </h3>

            <p class="text-slate-500 mt-2">
                Create and manage exam records.
            </p>

        </a>

        <a href="{{ route('admin.hackathons.index') }}"
           class="bg-white hover:shadow-2xl transition p-6 rounded-3xl border border-slate-200">

            <h3 class="text-xl font-bold text-slate-800">
                Manage Hackathons
            </h3>

            <p class="text-slate-500 mt-2">
                Create national and international hackathons.
            </p>

        </a>

        <a href="{{ route('admin.attempts') }}"
           class="bg-white hover:shadow-2xl transition p-6 rounded-3xl border border-slate-200">

            <h3 class="text-xl font-bold text-slate-800">
                Candidate Attempts
            </h3>

            <p class="text-slate-500 mt-2">
                View candidate submissions and results.
            </p>

        </a>

        <a href="{{ route('admin.leaderboard') }}"
           class="bg-white hover:shadow-2xl transition p-6 rounded-3xl border border-slate-200">

            <h3 class="text-xl font-bold text-slate-800">
                Leaderboard
            </h3>

            <p class="text-slate-500 mt-2">
                View top performing candidates.
            </p>

        </a>

    </div>

</div>

@endsection
@extends('layouts.admin')

@section('title', 'Leaderboard')

@section('content')

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-slate-500">Total Attempts</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalAttempts }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-slate-500">Shortlisted</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $shortlisted }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-slate-500">Rejected</h3>
        <p class="text-3xl font-bold text-red-600 mt-2">{{ $rejected }}</p>
    </div>

</div>

<!-- Leaderboard -->
<div class="bg-white rounded-2xl shadow p-6">
    <h3 class="text-2xl font-bold mb-6">Top Candidates</h3>

    <table class="w-full">
        <thead>
            <tr class="bg-slate-900 text-white">
                <th class="p-3 text-left">Rank</th>
                <th class="p-3 text-left">User</th>
                <th class="p-3 text-left">Exam</th>
                <th class="p-3 text-left">Score</th>
            </tr>
        </thead>

        <tbody>
            @foreach($topUsers as $index => $attempt)
            <tr class="border-b hover:bg-slate-50">
                <td class="p-3 font-bold">#{{ $index + 1 }}</td>
                <td class="p-3">{{ $attempt->user->name }}</td>
                <td class="p-3">{{ $attempt->exam->title }}</td>
                <td class="p-3 text-indigo-600 font-bold">{{ $attempt->score }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
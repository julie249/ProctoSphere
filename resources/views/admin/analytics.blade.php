@extends('layouts.admin')

@section('content')

<div class="p-6 bg-slate-100 min-h-screen">

    <div class="mb-8">
        <h1 class="text-4xl font-bold text-slate-800">Analytics Dashboard</h1>
        <p class="text-slate-500 mt-2">Track exams, candidates, results, and proctoring risk</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Total Candidates</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalCandidates }}</h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Total Hackathons</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalHackathons }}</h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Total Exams</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalExams }}</h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Total Attempts</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalAttempts }}</h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Shortlisted</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $shortlisted }}</h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Rejected</p>
            <h2 class="text-3xl font-bold text-red-600 mt-2">{{ $rejected }}</h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Total Violations</p>
            <h2 class="text-3xl font-bold text-orange-600 mt-2">{{ $totalViolations }}</h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">High Risk Attempts</p>
            <h2 class="text-3xl font-bold text-red-700 mt-2">{{ $highRisk }}</h2>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Shortlisted vs Rejected</h2>
            <canvas id="resultChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Risk Level Analysis</h2>
            <canvas id="riskChart"></canvas>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Monthly Exam Attempts</h2>
            <canvas id="attemptChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Violation Type Analytics</h2>
            <canvas id="violationChart"></canvas>
        </div>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Most Attempted Exams</h2>
        <canvas id="examChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const resultChart = document.getElementById('resultChart');

    new Chart(resultChart, {
        type: 'doughnut',
        data: {
            labels: ['Shortlisted', 'Rejected'],
            datasets: [{
                data: [{{ $shortlisted }}, {{ $rejected }}],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 1
            }]
        }
    });

    const riskChart = document.getElementById('riskChart');

    new Chart(riskChart, {
        type: 'bar',
        data: {
            labels: ['Safe', 'Medium Risk', 'High Risk'],
            datasets: [{
                label: 'Candidates',
                data: [{{ $safeCandidates }}, {{ $mediumRisk }}, {{ $highRisk }}],
                backgroundColor: ['#38bdf8', '#facc15', '#ef4444'],
                borderWidth: 1
            }]
        }
    });

    const attemptChart = document.getElementById('attemptChart');

    new Chart(attemptChart, {
        type: 'line',
        data: {
            labels: {!! json_encode($attemptMonths->keys()) !!},
            datasets: [{
                label: 'Attempts',
                data: {!! json_encode($attemptMonths->values()) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.2)',
                tension: 0.4,
                fill: true
            }]
        }
    });

    const violationChart = document.getElementById('violationChart');

    new Chart(violationChart, {
        type: 'pie',
        data: {
            labels: {!! json_encode($violationTypes->keys()) !!},
            datasets: [{
                data: {!! json_encode($violationTypes->values()) !!},
                backgroundColor: [
                    '#ef4444',
                    '#f59e0b',
                    '#3b82f6',
                    '#22c55e',
                    '#8b5cf6'
                ]
            }]
        }
    });

    const examChart = document.getElementById('examChart');

    new Chart(examChart, {
        type: 'bar',
        data: {
            labels: [
                @foreach($examAttempts as $attempt)
                    "{{ $attempt->exam->title ?? 'Exam' }}",
                @endforeach
            ],
            datasets: [{
                label: 'Attempts',
                data: [
                    @foreach($examAttempts as $attempt)
                        {{ $attempt->total }},
                    @endforeach
                ],
                backgroundColor: '#0f172a'
            }]
        }
    });
</script>

@endsection
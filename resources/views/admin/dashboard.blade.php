@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-slate-500">Total Exams</h3>
        <p class="text-3xl font-bold text-slate-800 mt-2">
            {{ \App\Models\Exam::count() }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-slate-500">Total Attempts</h3>
        <p class="text-3xl font-bold text-slate-800 mt-2">
            {{ \App\Models\ExamAttempt::count() }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-slate-500">Shortlisted</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">
            {{ \App\Models\ExamAttempt::where('status','shortlisted')->count() }}
        </p>
    </div>

</div>

@endsection
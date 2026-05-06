@extends('layouts.admin')

@section('title', 'Create Exam')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow p-8">
    <h3 class="text-2xl font-bold text-slate-800 mb-6">Create New Exam</h3>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.exams.store') }}" class="space-y-5">
        @csrf

        <!-- Exam Title -->
        <input class="w-full border rounded-lg p-3" type="text" name="title" placeholder="Exam Title" required>

        <!-- 🔥 Hackathon Dropdown -->
        <select name="hackathon_id" class="w-full border rounded-lg p-3" required>
            <option value="">Select Hackathon</option>
            @foreach($hackathons as $hackathon)
                <option value="{{ $hackathon->id }}">
                    {{ $hackathon->title }} ({{ ucfirst($hackathon->level) }})
                </option>
            @endforeach
        </select>

        <!-- Description -->
        <textarea class="w-full border rounded-lg p-3" name="description" placeholder="Description"></textarea>

        <!-- Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input class="border rounded-lg p-3" type="number" name="duration" placeholder="Duration in minutes" required>
            <input class="border rounded-lg p-3" type="number" name="total_marks" placeholder="Total Marks" required>
            <input class="border rounded-lg p-3" type="number" name="passing_marks" placeholder="Passing Marks" required>
            <input class="border rounded-lg p-3" type="number" name="negative_marks" placeholder="Negative Marks">
            <input class="border rounded-lg p-3" type="number" name="max_warnings" value="3" placeholder="Max Warnings">
        </div>

        <!-- Submit -->
        <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
            Create Exam
        </button>
    </form>
</div>
@endsection
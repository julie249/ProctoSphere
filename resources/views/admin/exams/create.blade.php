@extends('layouts.admin')

@section('title', 'Create Exam')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl shadow p-8">

    <h3 class="text-2xl font-bold text-slate-800 mb-2">
        Create New Exam
    </h3>

    <p class="text-slate-500 mb-6">
        Add exam details, marks, proctoring limits, and schedule window.
    </p>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.exams.store') }}" class="space-y-5">
        @csrf

        <input class="w-full border rounded-lg p-3"
               type="text"
               name="title"
               placeholder="Exam Title"
               required>

        <select name="hackathon_id" class="w-full border rounded-lg p-3" required>
            <option value="">Select Hackathon</option>
            @foreach($hackathons as $hackathon)
                <option value="{{ $hackathon->id }}">
                    {{ $hackathon->title }} ({{ ucfirst($hackathon->level) }})
                </option>
            @endforeach
        </select>

        <textarea class="w-full border rounded-lg p-3"
                  name="description"
                  placeholder="Description"></textarea>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input class="border rounded-lg p-3"
                   type="number"
                   name="duration"
                   placeholder="Duration in minutes"
                   required>

            <input class="border rounded-lg p-3"
                   type="number"
                   name="total_marks"
                   placeholder="Total Marks"
                   required>

            <input class="border rounded-lg p-3"
                   type="number"
                   name="passing_marks"
                   placeholder="Passing Marks"
                   required>

            <input class="border rounded-lg p-3"
                   type="number"
                   name="negative_marks"
                   placeholder="Negative Marks">

            <input class="border rounded-lg p-3"
                   type="number"
                   name="max_warnings"
                   value="3"
                   placeholder="Max Warnings">
        </div>

        <div class="border-t pt-6">
            <h4 class="text-lg font-bold text-slate-800 mb-3">
                Exam Schedule
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">
                        Exam Start Time
                    </label>

                    <input class="w-full border rounded-lg p-3"
                           type="datetime-local"
                           name="exam_start_time">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">
                        Exam End Time
                    </label>

                    <input class="w-full border rounded-lg p-3"
                           type="datetime-local"
                           name="exam_end_time">
                </div>

            </div>
        </div>

        <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
            Create Exam
        </button>
    </form>
</div>
@endsection
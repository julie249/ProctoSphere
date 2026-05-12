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

        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-2">
                Exam Title
            </label>

            <input class="w-full border rounded-lg p-3"
                   type="text"
                   name="title"
                   value="{{ old('title') }}"
                   placeholder="Exam Title"
                   required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-2">
                Select Hackathon
            </label>

            <select name="hackathon_id" class="w-full border rounded-lg p-3" required>
                <option value="">Select Hackathon</option>

                @foreach($hackathons as $hackathon)
                    <option value="{{ $hackathon->id }}"
                        {{ old('hackathon_id') == $hackathon->id ? 'selected' : '' }}>
                        {{ $hackathon->title }} ({{ ucfirst($hackathon->level) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-2">
                Description
            </label>

            <textarea class="w-full border rounded-lg p-3"
                      name="description"
                      rows="4"
                      placeholder="Description">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Duration
                </label>

                <input class="w-full border rounded-lg p-3"
                       type="number"
                       name="duration"
                       value="{{ old('duration') }}"
                       placeholder="Duration in minutes"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Total Marks
                </label>

                <input class="w-full border rounded-lg p-3"
                       type="number"
                       name="total_marks"
                       value="{{ old('total_marks') }}"
                       placeholder="Total Marks"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Passing Marks
                </label>

                <input class="w-full border rounded-lg p-3"
                       type="number"
                       name="passing_marks"
                       value="{{ old('passing_marks') }}"
                       placeholder="Passing Marks"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Negative Marks
                </label>

                <input class="w-full border rounded-lg p-3"
                       type="number"
                       step="0.01"
                       name="negative_marks"
                       value="{{ old('negative_marks', 0) }}"
                       placeholder="Negative Marks">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Maximum Warnings
                </label>

                <input class="w-full border rounded-lg p-3"
                       type="number"
                       name="max_warnings"
                       value="{{ old('max_warnings', 3) }}"
                       placeholder="Max Warnings">
            </div>

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
                           name="exam_start_time"
                           value="{{ old('exam_start_time') }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-2">
                        Exam End Time
                    </label>

                    <input class="w-full border rounded-lg p-3"
                           type="datetime-local"
                           name="exam_end_time"
                           value="{{ old('exam_end_time') }}">
                </div>

            </div>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   checked
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">

            <span class="font-semibold text-slate-700">
                Active Exam
            </span>
        </div>

        <div class="flex justify-between items-center pt-4">

            <a href="{{ route('admin.exams.index') }}"
               class="bg-slate-600 text-white px-6 py-3 rounded-lg hover:bg-slate-700">
                Back
            </a>

            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                Create Exam
            </button>

        </div>

    </form>
</div>
@endsection
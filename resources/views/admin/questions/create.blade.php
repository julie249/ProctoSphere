@extends('layouts.admin')

@section('title', 'Add Question')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl shadow p-8">
    <h3 class="text-2xl font-bold text-slate-800 mb-6">Add New Question</h3>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.questions.store') }}" class="space-y-5">
        @csrf

        <select name="exam_id" class="w-full border rounded-lg p-3" required>
            <option value="">Choose Exam</option>
            @foreach($exams as $exam)
                <option value="{{ $exam->id }}">{{ $exam->title }}</option>
            @endforeach
        </select>

        <textarea name="question" class="w-full border rounded-lg p-3" placeholder="Enter question" required></textarea>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input class="border rounded-lg p-3" type="text" name="option_a" placeholder="Option A" required>
            <input class="border rounded-lg p-3" type="text" name="option_b" placeholder="Option B" required>
            <input class="border rounded-lg p-3" type="text" name="option_c" placeholder="Option C" required>
            <input class="border rounded-lg p-3" type="text" name="option_d" placeholder="Option D" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <select name="correct_answer" class="border rounded-lg p-3" required>
                <option value="a">Correct: Option A</option>
                <option value="b">Correct: Option B</option>
                <option value="c">Correct: Option C</option>
                <option value="d">Correct: Option D</option>
            </select>

            <input class="border rounded-lg p-3" type="number" name="marks" value="1" required>
        </div>

        <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
            Add Question
        </button>
    </form>
</div>
@endsection
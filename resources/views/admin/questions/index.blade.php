@extends('layouts.admin')

@section('title', 'Questions')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-slate-800">All Questions</h3>

        <a href="{{ route('admin.questions.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
            + Add Question
        </a>
    </div>

    @if(session('success'))
        <p class="mb-4 text-green-600 font-semibold">{{ session('success') }}</p>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-900 text-white">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Exam</th>
                    <th class="p-3 text-left">Question</th>
                    <th class="p-3 text-left">Marks</th>
                    <th class="p-3 text-left">Correct</th>
                </tr>
            </thead>

            <tbody>
                @foreach($questions as $question)
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-3">{{ $question->id }}</td>
                    <td class="p-3">{{ $question->exam->title }}</td>
                    <td class="p-3">{{ $question->question }}</td>
                    <td class="p-3">{{ $question->marks }}</td>
                    <td class="p-3 font-bold text-green-600">
                        {{ strtoupper($question->correct_answer) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
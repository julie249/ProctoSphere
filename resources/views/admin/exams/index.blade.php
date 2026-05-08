@extends('layouts.admin')

@section('title', 'Exams')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-slate-800">All Exams</h3>

        <a href="{{ route('admin.exams.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
            + Create Exam
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
                    <th class="p-3 text-left">Hackathon</th>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Duration</th>
                    <th class="p-3 text-left">Total Marks</th>
                    <th class="p-3 text-left">Passing Marks</th>
                </tr>
            </thead>

            <tbody>
                @foreach($exams as $exam)
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-3">{{ $exam->id }}</td>
                    <td class="p-3">
    {{ $exam->hackathon->title ?? 'No Hackathon' }}
</td>
                    <td class="p-3 font-semibold">{{ $exam->title }}</td>
                    <td class="p-3">{{ $exam->duration }} mins</td>
                    <td class="p-3">{{ $exam->total_marks }}</td>

                    <td class="p-3">{{ $exam->passing_marks }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
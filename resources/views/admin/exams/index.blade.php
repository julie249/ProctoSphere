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
                    <th class="p-3 text-left">Marks</th>
                    <th class="p-3 text-left">Start Time</th>
                    <th class="p-3 text-left">End Time</th>
                    <th class="p-3 text-left">Schedule Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($exams as $exam)

                    @php
                        $now = now();

                        if (!$exam->exam_start_time || !$exam->exam_end_time) {
                            $status = 'Not Scheduled';
                            $statusClass = 'bg-gray-100 text-gray-700';
                        } elseif ($now->lt($exam->exam_start_time)) {
                            $status = 'Upcoming';
                            $statusClass = 'bg-blue-100 text-blue-700';
                        } elseif ($now->between($exam->exam_start_time, $exam->exam_end_time)) {
                            $status = 'Live';
                            $statusClass = 'bg-green-100 text-green-700';
                        } else {
                            $status = 'Expired';
                            $statusClass = 'bg-red-100 text-red-700';
                        }
                    @endphp

                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-3">{{ $exam->id }}</td>

                        <td class="p-3">
                            {{ $exam->hackathon->title ?? 'No Hackathon' }}
                        </td>

                        <td class="p-3 font-semibold">
                            {{ $exam->title }}
                        </td>

                        <td class="p-3">
                            {{ $exam->duration }} mins
                        </td>

                        <td class="p-3">
                            {{ $exam->passing_marks }} / {{ $exam->total_marks }}
                        </td>

                        <td class="p-3">
                            {{ $exam->exam_start_time ? $exam->exam_start_time->format('d M Y, h:i A') : '-' }}
                        </td>

                        <td class="p-3">
                            {{ $exam->exam_end_time ? $exam->exam_end_time->format('d M Y, h:i A') : '-' }}
                        </td>

                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                                {{ $status }}
                            </span>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-slate-500">
                            No exams found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
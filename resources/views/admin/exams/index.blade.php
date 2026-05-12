@extends('layouts.admin')

@section('title', 'Exams')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">All Exams</h3>
            <p class="text-slate-500 mt-1">
                Manage exams, schedule status, and active/inactive control.
            </p>
        </div>

        <a href="{{ route('admin.exams.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
            + Create Exam
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-slate-900 text-white">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Hackathon</th>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Duration</th>
                    <th class="p-3 text-left">Marks</th>
                    <th class="p-3 text-left">Start Time</th>
                    <th class="p-3 text-left">End Time</th>
                    <th class="p-3 text-left">Schedule</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($exams as $exam)

                    @php
                        $now = now();

                        if (!$exam->exam_start_time || !$exam->exam_end_time) {
                            $scheduleStatus = 'Not Scheduled';
                            $scheduleClass = 'bg-gray-100 text-gray-700';
                        } elseif ($now->lt($exam->exam_start_time)) {
                            $scheduleStatus = 'Upcoming';
                            $scheduleClass = 'bg-blue-100 text-blue-700';
                        } elseif ($now->between($exam->exam_start_time, $exam->exam_end_time)) {
                            $scheduleStatus = 'Live';
                            $scheduleClass = 'bg-green-100 text-green-700';
                        } else {
                            $scheduleStatus = 'Expired';
                            $scheduleClass = 'bg-red-100 text-red-700';
                        }
                    @endphp

                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-3">
                            {{ $exam->id }}
                        </td>

                        <td class="p-3">
                            {{ $exam->hackathon->title ?? 'No Hackathon' }}
                        </td>

                        <td class="p-3 font-semibold text-slate-800">
                            {{ $exam->title }}
                        </td>

                        <td class="p-3">
                            {{ $exam->duration ?? '-' }} mins
                        </td>

                        <td class="p-3">
                            {{ $exam->passing_marks }} / {{ $exam->total_marks }}
                        </td>

                        <td class="p-3 whitespace-nowrap">
                            {{ $exam->exam_start_time ? $exam->exam_start_time->format('d M Y, h:i A') : '-' }}
                        </td>

                        <td class="p-3 whitespace-nowrap">
                            {{ $exam->exam_end_time ? $exam->exam_end_time->format('d M Y, h:i A') : '-' }}
                        </td>

                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $scheduleClass }}">
                                {{ $scheduleStatus }}
                            </span>
                        </td>

                        <td class="p-3">
                            @if($exam->is_active)
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            <div class="flex flex-wrap gap-2">

                                <a href="{{ route('admin.exams.edit', $exam->id) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.exams.toggleStatus', $exam->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="{{ $exam->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }} text-white px-3 py-2 rounded-lg text-sm">
                                        {{ $exam->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.exams.destroy', $exam->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this exam?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="10" class="p-6 text-center text-slate-500">
                            No exams found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Candidate Results')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <h3 class="text-2xl font-bold text-slate-800 mb-6">All Candidate Attempts</h3>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-slate-900 text-white">
                
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Exam</th>
                    <th class="p-3 text-left">Score</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Violations</th>
                    <th class="p-3 text-left">Logs</th>
                </tr>
            </thead>

            <tbody>
                @foreach($attempts as $attempt)
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-3">{{ $attempt->user->name }}</td>
                    <td class="p-3">{{ $attempt->exam->title }}</td>
                    <td class="p-3 font-semibold">{{ $attempt->score }}</td>
                    <td class="p-3">
                        @if($attempt->status == 'shortlisted')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                                Shortlisted
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                                Rejected
                            </span>
                        @endif
                    </td>
                    <td class="p-3">{{ $attempt->created_at }}</td>
                    <td class="p-3">
                        <a href="{{ route('admin.logs', [$attempt->user_id, $attempt->exam_id]) }}"
                           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            View Logs
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Proctor Logs')

@section('content')

<div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">

    <div class="p-6 border-b">
        <h1 class="text-3xl font-bold text-slate-800">Proctor Logs</h1>
        <p class="text-slate-500 mt-2">
            Monitor candidate violations, suspicious activities, and captured snapshots.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="px-6 py-4 text-left">#</th>
                    <th class="px-6 py-4 text-left">Candidate</th>
                    <th class="px-6 py-4 text-left">Exam</th>
                    <th class="px-6 py-4 text-left">Event Type</th>
                    <th class="px-6 py-4 text-left">Details</th>
                    <th class="px-6 py-4 text-left">Date & Time</th>
                    <th class="px-6 py-4 text-left">Snapshot</th>
                </tr>
            </thead>

            <tbody>
                @forelse($logs as $index => $log)
                    <tr class="border-b hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-semibold">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $log->user->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $log->exam->title ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $log->event_type }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $log->details ?? 'No details' }}
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $log->created_at->format('d M Y, h:i A') }}
                        </td>

                        <td class="px-6 py-4">
                            @if($log->snapshot)
                                <a href="{{ asset('storage/' . $log->snapshot) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $log->snapshot) }}"
                                         class="w-28 h-20 rounded-xl object-cover border shadow">
                                </a>
                            @else
                                <span class="text-slate-400">No Snapshot</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-slate-500">
                            No proctor logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
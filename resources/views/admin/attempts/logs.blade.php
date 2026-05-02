@extends('layouts.admin')

@section('title', 'Proctor Logs')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-slate-800">Cheating / Proctor Logs</h3>

        <a href="/admin/attempts"
           class="bg-slate-700 text-white px-5 py-2 rounded-lg hover:bg-slate-800">
            Back
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-900 text-white">
                    <th class="p-3 text-left">Event</th>
                    <th class="p-3 text-left">Details</th>
                    <th class="p-3 text-left">Time</th>
                </tr>
            </thead>

            <tbody>
                @foreach($logs as $log)
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-3 font-semibold text-indigo-600">
                        {{ $log->event_type }}
                    </td>
                    <td class="p-3">{{ $log->details }}</td>
                    <td class="p-3">{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
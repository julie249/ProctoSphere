@extends('layouts.admin')

@section('title', 'Hackathons')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-slate-800">All Hackathons</h3>

        <a href="{{ route('admin.hackathons.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
            + Create Hackathon
        </a>
    </div>

    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif

    <table class="w-full">
        <thead>
            <tr class="bg-slate-900 text-white">
                <th class="p-3 text-left">Title</th>
                <th class="p-3 text-left">Level</th>
                <th class="p-3 text-left">Start</th>
                <th class="p-3 text-left">End</th>
            </tr>
        </thead>

        <tbody>
            @foreach($hackathons as $hackathon)
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-3 font-semibold">{{ $hackathon->title }}</td>
                    <td class="p-3">{{ ucfirst($hackathon->level) }}</td>
                    <td class="p-3">{{ $hackathon->start_date }}</td>
                    <td class="p-3">{{ $hackathon->end_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
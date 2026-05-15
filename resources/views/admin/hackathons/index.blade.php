@extends('layouts.admin')

@section('title', 'Hackathons')

@section('content')
<div class="bg-white rounded-2xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">All Hackathons</h3>
            <p class="text-slate-500 mt-1">
                Manage hackathons and remove unwanted records.
            </p>
        </div>

        <a href="{{ route('admin.hackathons.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
            + Create Hackathon
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
        <table class="w-full">
            <thead>
                <tr class="bg-slate-900 text-white">
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Level</th>
                    <th class="p-3 text-left">Start</th>
                    <th class="p-3 text-left">End</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($hackathons as $hackathon)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-3 font-semibold">
                            {{ $hackathon->title }}
                        </td>

                        <td class="p-3">
                            {{ ucfirst($hackathon->level) }}
                        </td>

                        <td class="p-3">
                            {{ $hackathon->start_date }}
                        </td>

                        <td class="p-3">
                            {{ $hackathon->end_date }}
                        </td>

                        <td class="p-3">
                            <form action="{{ route('admin.hackathons.destroy', $hackathon->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this hackathon? This will also delete related exams, questions, attempts, tokens, registrations, and proctor logs.');">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-slate-500">
                            No hackathons found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
@extends('layouts.admin')

@section('title', 'Hackathon Registrations')

@section('content')

<div class="bg-white rounded-3xl shadow p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Hackathon Registrations
            </h1>

            <p class="text-slate-500 mt-1">
                View all registered candidates
            </p>
        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>
                <tr class="bg-slate-900 text-white">

                    <th class="p-4 text-left">Candidate</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Hackathon</th>
                    <th class="p-4 text-left">Level</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Registered At</th>

                </tr>
            </thead>

            <tbody>

                @forelse($registrations as $registration)

                    <tr class="border-b hover:bg-slate-50">

                        <td class="p-4 font-semibold">
                            {{ $registration->user->name ?? 'N/A' }}
                        </td>

                        <td class="p-4">
                            {{ $registration->user->email ?? 'N/A' }}
                        </td>

                        <td class="p-4">
                            {{ $registration->hackathon->title ?? 'N/A' }}
                        </td>

                        <td class="p-4">
                            {{ ucfirst($registration->hackathon->level ?? '-') }}
                        </td>

                        <td class="p-4">

                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">

                                {{ ucfirst($registration->status) }}

                            </span>

                        </td>

                        <td class="p-4 text-slate-600">
                            {{ $registration->created_at->format('d M Y, h:i A') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="p-6 text-center text-slate-500">

                            No registrations found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
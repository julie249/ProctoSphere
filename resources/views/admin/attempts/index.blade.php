@extends('layouts.admin')

@section('title', 'Candidate Attempts')

@section('content')

<div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-6">

    <div class="flex justify-between items-center mb-8 flex-wrap gap-4">

        <div>
            <h3 class="text-3xl font-bold text-slate-800">
                Candidate Attempts
            </h3>

            <p class="text-slate-500 mt-2">
                Monitor candidate performance, violations, and shortlist status.
            </p>
        </div>

        <!-- Export + Total Attempts -->
        <div class="flex gap-3 items-center">

            <a href="{{ route('admin.attempts.export') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-2xl font-semibold transition">

                Export CSV

            </a>

            <div class="bg-indigo-100 text-indigo-700 px-5 py-3 rounded-2xl font-semibold">

                Total Attempts:
                {{ $attempts->count() }}

            </div>

        </div>

    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200">

        <table class="w-full border-collapse">

            <thead>

                <tr class="bg-slate-900 text-white">

                    <th class="p-4 text-left">#</th>

                    <th class="p-4 text-left">Candidate</th>

                    <th class="p-4 text-left">Exam</th>

                    <th class="p-4 text-left">Score</th>

                    <th class="p-4 text-left">Violations</th>

                    <th class="p-4 text-left">Risk Level</th>

                    <th class="p-4 text-left">Status</th>

                    <th class="p-4 text-left">Date</th>

                    <th class="p-4 text-left">Logs</th>

                </tr>

            </thead>

            <tbody>

                @forelse($attempts as $index => $attempt)

                    <tr class="border-b hover:bg-slate-50 transition">

                        <!-- Serial -->
                        <td class="p-4 font-semibold text-slate-700">
                            {{ $index + 1 }}
                        </td>

                        <!-- Candidate -->
                        <td class="p-4">

                            <div>

                                <p class="font-semibold text-slate-800">
                                    {{ $attempt->user->name }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    ID: {{ $attempt->user_id }}
                                </p>

                            </div>

                        </td>

                        <!-- Exam -->
                        <td class="p-4">

                            <div>

                                <p class="font-semibold text-slate-800">
                                    {{ $attempt->exam->title }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    Exam ID: {{ $attempt->exam_id }}
                                </p>

                            </div>

                        </td>

                        <!-- Score -->
                        <td class="p-4">

                            <span class="font-bold text-lg text-indigo-600">
                                {{ $attempt->score }}
                            </span>

                        </td>

                        <!-- Violations -->
                        <td class="p-4">

                            @if($attempt->violations >= 5)

                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                                    {{ $attempt->violations }}
                                </span>

                            @elseif($attempt->violations >= 3)

                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    {{ $attempt->violations }}
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                                    {{ $attempt->violations }}
                                </span>

                            @endif

                        </td>

                        <!-- Risk Level -->
                        <td class="p-4">

                            @if($attempt->violations >= 5)

                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                                    High Risk
                                </span>

                            @elseif($attempt->violations >= 3)

                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    Medium Risk
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                                    Safe
                                </span>

                            @endif

                        </td>

                        <!-- Status -->
                        <td class="p-4">

                            @if($attempt->status == 'shortlisted')

                                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 font-semibold">
                                    Shortlisted
                                </span>

                            @else

                                <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 font-semibold">
                                    Rejected
                                </span>

                            @endif

                        </td>

                        <!-- Date -->
                        <td class="p-4 text-slate-600">

                            {{ $attempt->created_at->format('d M Y') }}

                            <div class="text-sm text-slate-400 mt-1">
                                {{ $attempt->created_at->format('h:i A') }}
                            </div>

                        </td>

                        <!-- Logs -->
                        <td class="p-4">

                            <a href="{{ route('admin.logs', [$attempt->user_id, $attempt->exam_id]) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">

                                🚨 View Logs

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="text-center py-12 text-slate-500">

                            No candidate attempts found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
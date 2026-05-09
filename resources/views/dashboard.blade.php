<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            Candidate Dashboard
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow p-6 mb-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-2">
                    Welcome to ProctoSphere
                </h3>
                <p class="text-slate-500">
                    Register for a hackathon first, then access the assigned screening exams.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 mb-8">
                <h3 class="text-xl font-bold text-slate-800 mb-4">
                    Available Hackathons
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($hackathons as $hackathon)

                        @php
                            $isRegistered = auth()->user()
                                ->hackathonRegistrations()
                                ->where('hackathon_id', $hackathon->id)
                                ->exists();
                        @endphp

                        <div class="border rounded-2xl p-5 hover:shadow-lg transition bg-white">
                            <h4 class="text-lg font-bold text-slate-800">
                                {{ $hackathon->title }}
                            </h4>

                            <p class="text-slate-500 mt-2">
                                {{ $hackathon->description }}
                            </p>

                            <p class="mt-3 text-sm text-slate-600">
                                Level: {{ ucfirst($hackathon->level) }}
                            </p>

                            <p class="text-sm text-slate-600">
                                {{ $hackathon->start_date }} to {{ $hackathon->end_date }}
                            </p>

                            @if($isRegistered)

                                <div class="mt-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold text-center">
                                    Already Registered
                                </div>

                                <a href="{{ route('candidate.hackathon.exams', $hackathon->id) }}"
                                   class="block text-center mt-3 bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                                    View Exams
                                </a>

                            @else

                                <form action="{{ route('candidate.hackathons.register', $hackathon->id) }}"
                                      method="POST"
                                      class="mt-4">
                                    @csrf

                                    <button type="submit"
                                            class="w-full bg-slate-900 hover:bg-slate-800 text-white px-5 py-2 rounded-lg font-semibold transition">
                                        Register for Hackathon
                                    </button>
                                </form>

                            @endif
                        </div>

                    @empty

                        <div class="col-span-3 text-center text-slate-500 py-10">
                            No hackathons available right now.
                        </div>

                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-4">
                    My Previous Results
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-900 text-white">
                                <th class="p-3 text-left">Exam</th>
                                <th class="p-3 text-left">Score</th>
                                <th class="p-3 text-left">Violations</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($attempts as $attempt)
                                <tr class="border-b hover:bg-slate-50">
                                    <td class="p-3">{{ $attempt->exam->title ?? 'N/A' }}</td>
                                    <td class="p-3 font-semibold">{{ $attempt->score }}</td>
                                    <td class="p-3 font-bold text-red-600">{{ $attempt->violations }}</td>
                                    <td class="p-3">
                                        @if($attempt->status == 'shortlisted')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-semibold">
                                                Shortlisted
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full font-semibold">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3">{{ $attempt->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-slate-500">
                                        No previous exam results found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
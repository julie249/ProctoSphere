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
                    Select a hackathon and start the assigned screening exam.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 mb-8">
                <h3 class="text-xl font-bold text-slate-800 mb-4">
                    Available Hackathons
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($hackathons as $hackathon)
                        <div class="border rounded-2xl p-5 hover:shadow-lg transition">
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

                            <a href="{{ route('candidate.hackathon.exams', $hackathon->id) }}"
                               class="inline-block mt-4 bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                                View Exams
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-4">
                    My Previous Results
                </h3>

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
                        @foreach($attempts as $attempt)
                            <tr class="border-b hover:bg-slate-50">
                                <td class="p-3">{{ $attempt->exam->title }}</td>
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
                                <td class="p-3">{{ $attempt->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
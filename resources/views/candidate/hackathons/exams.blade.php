<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            Hackathon Exams
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">

        <div class="max-w-7xl mx-auto px-6">

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow p-8 mb-8">

                <h1 class="text-4xl font-bold text-slate-800">
                    {{ $hackathon->title }}
                </h1>

                <p class="text-slate-500 mt-3">
                    Exams available for this hackathon screening process.
                </p>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($exams as $exam)

                    @php
                        $now = now();

                        if (!$exam->exam_start_time || !$exam->exam_end_time) {
                            $scheduleStatus = 'Open Anytime';
                            $scheduleClass = 'bg-gray-100 text-gray-700';
                            $canStart = true;
                        } elseif ($now->lt($exam->exam_start_time)) {
                            $scheduleStatus = 'Upcoming';
                            $scheduleClass = 'bg-blue-100 text-blue-700';
                            $canStart = false;
                        } elseif ($now->between($exam->exam_start_time, $exam->exam_end_time)) {
                            $scheduleStatus = 'Live Now';
                            $scheduleClass = 'bg-green-100 text-green-700';
                            $canStart = true;
                        } else {
                            $scheduleStatus = 'Expired';
                            $scheduleClass = 'bg-red-100 text-red-700';
                            $canStart = false;
                        }
                    @endphp

                    <div class="bg-white rounded-3xl shadow hover:shadow-xl transition p-6 border border-slate-200">

                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-slate-800">
                                {{ $exam->title }}
                            </h2>

                            <p class="text-slate-500 mt-2">
                                {{ $exam->description }}
                            </p>
                        </div>

                        <div class="space-y-3 mt-5">

                            <div class="flex justify-between">
                                <span class="text-slate-500">Duration</span>
                                <span class="font-semibold text-slate-700">
                                    {{ $exam->duration }} mins
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Total Marks</span>
                                <span class="font-semibold text-slate-700">
                                    {{ $exam->total_marks }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Passing Marks</span>
                                <span class="font-semibold text-green-600">
                                    {{ $exam->passing_marks }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Negative Marking</span>
                                <span class="font-semibold text-red-600">
                                    {{ $exam->negative_marks }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Schedule</span>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $scheduleClass }}">
                                    {{ $scheduleStatus }}
                                </span>
                            </div>

                            @if($exam->exam_start_time && $exam->exam_end_time)
                                <div class="bg-slate-50 rounded-xl p-3 text-sm text-slate-600">
                                    <p>
                                        <strong>Starts:</strong>
                                        {{ $exam->exam_start_time->format('d M Y, h:i A') }}
                                    </p>

                                    <p>
                                        <strong>Ends:</strong>
                                        {{ $exam->exam_end_time->format('d M Y, h:i A') }}
                                    </p>
                                </div>
                            @endif

                        </div>

                        <div class="mt-6">

                            @if($canStart)

                                <a href="{{ route('candidate.exam.token', $exam->id) }}"
                                   class="block text-center bg-indigo-600 hover:bg-indigo-700 transition text-white py-3 rounded-xl font-semibold">
                                    Start Secure Exam
                                </a>

                            @else

                                <button disabled
                                        class="w-full bg-slate-300 text-slate-600 py-3 rounded-xl font-semibold cursor-not-allowed">
                                    {{ $scheduleStatus == 'Upcoming' ? 'Exam Not Started' : 'Exam Expired' }}
                                </button>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="col-span-3 bg-white rounded-3xl shadow p-10 text-center">

                        <h3 class="text-2xl font-bold text-slate-700 mb-2">
                            No Active Exams
                        </h3>

                        <p class="text-slate-500">
                            There are currently no active exams for this hackathon.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>
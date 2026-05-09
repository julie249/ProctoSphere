<x-app-layout>
    <div class="p-8">
        <h1 class="text-3xl font-bold">{{ $hackathon->title }}</h1>
        <p class="text-gray-600 mb-6">Exams available for this hackathon</p>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($exams as $exam)
                <div class="bg-white p-6 rounded-xl shadow border">
                    <h2 class="text-xl font-bold">{{ $exam->title }}</h2>

                    <p class="text-gray-600 mt-2">
                        {{ $exam->description }}
                    </p>

                    <p class="mt-3">
                        <b>Duration:</b> {{ $exam->duration }} minutes
                    </p>

                    <p>
                        <b>Total Marks:</b> {{ $exam->total_marks }}
                    </p>

                    <p>
                        <b>Passing Marks:</b> {{ $exam->passing_marks }}
                    </p>

                    <a href="{{ route('candidate.exam.instructions', $exam->id) }}"
                       class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded-lg">
                        Start Process
                    </a>
                </div>
            @empty
                <p>No active exams available for this hackathon.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
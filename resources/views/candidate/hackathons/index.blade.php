<x-app-layout>
    <div class="p-8">
        <h1 class="text-3xl font-bold mb-6">Available Hackathons</h1>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($hackathons as $hackathon)
                <div class="bg-white p-6 rounded-xl shadow border">
                    <h2 class="text-xl font-bold">{{ $hackathon->title }}</h2>

                    <p class="text-gray-600 mt-2">
                        {{ $hackathon->description }}
                    </p>

                    <p class="mt-3">
                        <b>Level:</b> {{ $hackathon->level }}
                    </p>

                    <p>
                        <b>Start:</b> {{ $hackathon->start_date }}
                    </p>

                    <p>
                        <b>End:</b> {{ $hackathon->end_date }}
                    </p>

                    <a href="{{ route('candidate.hackathon.exams', $hackathon->id) }}"
                       class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">
                        View Exams
                    </a>
                </div>
            @empty
                <p>No hackathons available.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
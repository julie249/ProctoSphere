<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            Exam Token Verification
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-2xl mx-auto px-6">

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow p-8">

                <h1 class="text-3xl font-bold text-slate-800 mb-2">
                    Enter Exam Token
                </h1>

                <p class="text-slate-500 mb-6">
                    Enter the secure token provided by the hackathon organizer to continue.
                </p>

                <form action="{{ route('candidate.exam.verifyToken', $exam->id) }}" method="POST">
                    @csrf

                    <input type="text"
                           name="token"
                           required
                           placeholder="Enter token"
                           class="w-full border rounded-xl px-4 py-3 mb-5 focus:ring-2 focus:ring-indigo-500">

                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold">
                        Verify Token
                    </button>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
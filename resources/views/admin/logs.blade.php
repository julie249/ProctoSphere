<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proctor Logs | ProctoSphere</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

<div class="max-w-7xl mx-auto py-10 px-6">

    <div class="mb-8 flex justify-between items-center">

        <div>
            <h1 class="text-4xl font-bold text-slate-800">
                Proctor Logs
            </h1>

            <p class="text-slate-500 mt-2">
                Monitor candidate violations and suspicious activities
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-slate-700 hover:bg-slate-800 text-white px-5 py-3 rounded-xl font-semibold">
            Back to Dashboard
        </a>

    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-800 text-white">

                    <tr>
                        <th class="px-6 py-4 text-left">#</th>
                        <th class="px-6 py-4 text-left">Candidate</th>
                        <th class="px-6 py-4 text-left">Exam</th>
                        <th class="px-6 py-4 text-left">Event Type</th>
                        <th class="px-6 py-4 text-left">Details</th>
                        <th class="px-6 py-4 text-left">Date & Time</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($logs as $index => $log)

                        <tr class="border-b hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $log->user->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $log->exam->title ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $log->event_type }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $log->details }}
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ $log->created_at->format('d M Y, h:i A') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-10 text-slate-500">

                                No proctor logs found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
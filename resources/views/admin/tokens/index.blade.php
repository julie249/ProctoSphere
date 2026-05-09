@extends('layouts.admin')

@section('title', 'Exam Tokens')

@section('content')

<div class="bg-white rounded-3xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Exam Tokens</h1>
            <p class="text-slate-500 mt-1">Generate and manage secure exam access tokens</p>
        </div>

        <form action="{{ route('admin.tokens.generate') }}" method="POST">
            @csrf
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">
                Generate Tokens
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-900 text-white">
                    <th class="p-4 text-left">Candidate</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Exam</th>
                    <th class="p-4 text-left">Token</th>
                    <th class="p-4 text-left">Used</th>
                    <th class="p-4 text-left">Used At</th>
                </tr>
            </thead>

            <tbody>
                @forelse($tokens as $token)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-4 font-semibold">{{ $token->user->name ?? 'N/A' }}</td>
                        <td class="p-4">{{ $token->user->email ?? 'N/A' }}</td>
                        <td class="p-4">{{ $token->exam->title ?? 'N/A' }}</td>
                        <td class="p-4 font-mono font-bold text-indigo-700">{{ $token->token }}</td>
                        <td class="p-4">
                            @if($token->is_used)
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full font-semibold">Used</span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-semibold">Unused</span>
                            @endif
                        </td>
                        <td class="p-4">
                            {{ $token->used_at ? $token->used_at->format('d M Y, h:i A') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-500">
                            No tokens generated yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
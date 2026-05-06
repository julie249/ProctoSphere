@extends('layouts.admin')

@section('title', 'Create Hackathon')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow p-8">
    <h3 class="text-2xl font-bold text-slate-800 mb-6">
        Create New Hackathon
    </h3>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.hackathons.store') }}" class="space-y-5">
        @csrf

        <input class="w-full border rounded-lg p-3"
               type="text"
               name="title"
               placeholder="Hackathon Title"
               required>

        <textarea class="w-full border rounded-lg p-3"
                  name="description"
                  placeholder="Hackathon Description"></textarea>

        <select name="level" class="w-full border rounded-lg p-3">
            <option value="national">National</option>
            <option value="international">International</option>
        </select>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input class="border rounded-lg p-3" type="date" name="start_date" required>
            <input class="border rounded-lg p-3" type="date" name="end_date" required>
        </div>

        <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
            Create Hackathon
        </button>
    </form>
</div>
@endsection
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            Edit Exam
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-6">

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-lg p-8">

                <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block font-semibold mb-2 text-gray-700">
                            Select Hackathon
                        </label>

                        <select name="hackathon_id"
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select Hackathon --</option>

                            @foreach($hackathons as $hackathon)
                                <option value="{{ $hackathon->id }}"
                                    {{ old('hackathon_id', $exam->hackathon_id) == $hackathon->id ? 'selected' : '' }}>
                                    {{ $hackathon->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold mb-2 text-gray-700">
                            Exam Title
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title', $exam->title) }}"
                               class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Enter exam title">
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold mb-2 text-gray-700">
                            Description
                        </label>

                        <textarea name="description"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Enter exam description">{{ old('description', $exam->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">
                                Duration
                            </label>

                            <input type="number"
                                   name="duration"
                                   value="{{ old('duration', $exam->duration) }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Duration in minutes">
                        </div>

                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">
                                Total Marks
                            </label>

                            <input type="number"
                                   name="total_marks"
                                   value="{{ old('total_marks', $exam->total_marks) }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Total marks">
                        </div>

                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">
                                Passing Marks
                            </label>

                            <input type="number"
                                   name="passing_marks"
                                   value="{{ old('passing_marks', $exam->passing_marks) }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Passing marks">
                        </div>

                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">
                                Negative Marks
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="negative_marks"
                                   value="{{ old('negative_marks', $exam->negative_marks) }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Negative marks">
                        </div>

                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">
                                Maximum Warnings
                            </label>

                            <input type="number"
                                   name="max_warnings"
                                   value="{{ old('max_warnings', $exam->max_warnings) }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Maximum warnings">
                        </div>

                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">
                                Start Time
                            </label>

                            <input type="datetime-local"
                                   name="exam_start_time"
                                   value="{{ old('exam_start_time', $exam->exam_start_time ? \Carbon\Carbon::parse($exam->exam_start_time)->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">
                                End Time
                            </label>

                            <input type="datetime-local"
                                   name="exam_end_time"
                                   value="{{ old('exam_end_time', $exam->exam_end_time ? \Carbon\Carbon::parse($exam->exam_end_time)->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                    </div>

                    <div class="mt-6">
                        <label class="flex items-center gap-3">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $exam->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">

                            <span class="font-semibold text-gray-700">
                                Active Exam
                            </span>
                        </label>
                    </div>

                    <div class="mt-8 flex justify-between items-center">

                        <a href="{{ route('admin.exams.index') }}"
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-semibold">
                            Back
                        </a>

                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">
                            Update Exam
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
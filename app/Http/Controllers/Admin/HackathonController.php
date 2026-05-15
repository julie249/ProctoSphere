<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Hackathon;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use App\Models\ExamToken;
use App\Models\ProctorLog;
use App\Models\HackathonRegistration;

class HackathonController extends Controller
{
    // Show all hackathons
    public function index()
    {
        $hackathons = Hackathon::latest()->get();

        return view('admin.hackathons.index', compact('hackathons'));
    }

    // Show create form
    public function create()
    {
        return view('admin.hackathons.create');
    }

    // Store hackathon
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Hackathon::create([
            'title' => $request->title,
            'description' => $request->description,
            'level' => $request->level ?? 'national',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => 1,
        ]);

        return redirect()
            ->route('admin.hackathons.index')
            ->with('success', 'Hackathon created successfully.');
    }

    // Delete hackathon with related data
    public function destroy(Hackathon $hackathon)
    {
        DB::transaction(function () use ($hackathon) {

            $examIds = Exam::where('hackathon_id', $hackathon->id)
                ->pluck('id');

            if ($examIds->isNotEmpty()) {

                // Delete exam-related data
                Question::whereIn('exam_id', $examIds)->delete();

                ExamAttempt::whereIn('exam_id', $examIds)->delete();

                ExamToken::whereIn('exam_id', $examIds)->delete();

                ProctorLog::whereIn('exam_id', $examIds)->delete();

                // Delete exams under this hackathon
                Exam::whereIn('id', $examIds)->delete();
            }

            // Delete hackathon registrations
            HackathonRegistration::where('hackathon_id', $hackathon->id)->delete();

            // Delete hackathon
            $hackathon->delete();
        });

        return redirect()
            ->route('admin.hackathons.index')
            ->with('success', 'Hackathon and all related data deleted successfully.');
    }
}
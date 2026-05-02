<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ProctorLog;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required|integer',
            'total_marks' => 'required|integer',
            'passing_marks' => 'required|integer',
        ]);

        Exam::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'total_marks' => $request->total_marks,
            'passing_marks' => $request->passing_marks,
            'negative_marks' => $request->negative_marks ?? 0,
            'max_warnings' => $request->max_warnings ?? 3,
            'is_active' => $request->is_active ?? 1,
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'Exam created successfully');
    }

    public function attempts()
    {
        $attempts = ExamAttempt::with('user', 'exam')->latest()->get();

        return view('admin.attempts.index', compact('attempts'));
    }
    public function logs($user_id, $exam_id)
{
    $logs = ProctorLog::where('user_id', $user_id)
        ->where('exam_id', $exam_id)
        ->latest()
        ->get();

    return view('admin.attempts.logs', compact('logs'));
}

public function leaderboard()
{
    $topUsers = \App\Models\ExamAttempt::with('user', 'exam')
        ->orderByDesc('score')
        ->take(10)
        ->get();

    $totalAttempts = \App\Models\ExamAttempt::count();
    $shortlisted = \App\Models\ExamAttempt::where('status', 'shortlisted')->count();
    $rejected = \App\Models\ExamAttempt::where('status', 'rejected')->count();

    return view('admin.leaderboard', compact('topUsers', 'totalAttempts', 'shortlisted', 'rejected'));
}
}

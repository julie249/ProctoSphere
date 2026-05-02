<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function instructions($id)
    {
        $exam = Exam::findOrFail($id);

        return view('candidate.instructions', compact('exam'));
    }

    public function start($id)
    {
        $exam = Exam::findOrFail($id);

        $alreadyAttempted = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $id)
            ->exists();

        if ($alreadyAttempted) {
            return redirect('/dashboard')->with('error', 'You have already attempted this exam.');
        }

        $questions = Question::where('exam_id', $id)->get();

        return view('candidate.exam', compact('exam', 'questions'));
    }

    public function submit(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = Question::where('exam_id', $id)->get();

        $score = 0;

        foreach ($questions as $question) {
            $answer = $request->input('answers.' . $question->id);

            if ($answer == $question->correct_answer) {
                $score += $question->marks;
            } else {
                $score -= $exam->negative_marks;
            }
        }

        $violations = \App\Models\ProctorLog::where('user_id', Auth::id())
            ->where('exam_id', $id)
            ->count();

        $penalty = $violations * 1;
        $finalScore = $score - $penalty;

        $attempt = ExamAttempt::create([
            'user_id' => Auth::id(),
            'exam_id' => $id,
            'score' => $finalScore,
            'total_questions' => $questions->count(),
            'violations' => $violations,
            'status' => $finalScore >= $exam->passing_marks ? 'shortlisted' : 'rejected',
            'submitted_at' => now(),
        ]);

        return view('candidate.result', compact('attempt'));
    }
}
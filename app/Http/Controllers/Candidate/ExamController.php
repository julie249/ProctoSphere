<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use App\Models\ProctorLog;
use App\Models\Hackathon;

class ExamController extends Controller
{
    public function hackathons()
    {
        $hackathons = Hackathon::latest()->get();

        return view('candidate.hackathons.index', compact('hackathons'));
    }

    public function hackathonExams(Hackathon $hackathon)
    {
        $exams = Exam::where('hackathon_id', $hackathon->id)
            ->where('is_active', true)
            ->get();

        return view('candidate.hackathons.exams', compact('hackathon', 'exams'));
    }

    public function instructions(Exam $exam)
    {
        $alreadyAttempted = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->exists();

        if ($alreadyAttempted) {
            return redirect()->route('dashboard')
                ->with('error', 'You have already attempted this exam.');
        }

        return view('candidate.instructions', compact('exam'));
    }

    public function webcam(Exam $exam)
    {
        return view('candidate.webcam', compact('exam'));
    }

    public function start(Exam $exam)
    {
        $alreadyAttempted = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->exists();

        if ($alreadyAttempted) {
            return redirect()->route('dashboard')
                ->with('error', 'You have already attempted this exam.');
        }

        $questions = Question::where('exam_id', $exam->id)->get();

        return view('candidate.exam', compact('exam', 'questions'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $questions = Question::where('exam_id', $exam->id)->get();

        $score = 0;
        $correctAnswers = 0;
        $wrongAnswers = 0;

        foreach ($questions as $question) {
            $answer = $request->input('answers.' . $question->id);

            if ($answer == $question->correct_answer) {
                $score += $question->marks;
                $correctAnswers++;
            } else {
                $score -= $exam->negative_marks ?? 0;
                $wrongAnswers++;
            }
        }

        $violations = ProctorLog::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->count();

        $penalty = $violations * 1;
        $finalScore = $score - $penalty;

        if ($finalScore < 0) {
            $finalScore = 0;
        }

        $attempt = ExamAttempt::create([
            'user_id' => Auth::id(),
            'exam_id' => $exam->id,
            'score' => $finalScore,
            'total_questions' => $questions->count(),
            'violations' => $violations,
            'status' => $finalScore >= $exam->passing_marks ? 'shortlisted' : 'rejected',
            'submitted_at' => now(),
        ]);

        return view('candidate.result', compact(
            'attempt',
            'exam',
            'questions',
            'correctAnswers',
            'wrongAnswers',
            'violations',
            'finalScore'
        ));
    }
}
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
use App\Models\HackathonRegistration;
use App\Models\ExamToken;

class ExamController extends Controller
{
    private function isRegisteredForHackathon($hackathonId)
    {
        return HackathonRegistration::where('user_id', Auth::id())
            ->where('hackathon_id', $hackathonId)
            ->exists();
    }

    private function hasVerifiedToken($examId)
    {
        return session('verified_exam_token_' . $examId) === true;
    }

    // Exam Schedule Protection
    private function checkExamSchedule(Exam $exam)
    {
        if (!$exam->exam_start_time || !$exam->exam_end_time) {
            return null;
        }

        if (now()->lt($exam->exam_start_time)) {
            return 'This exam has not started yet. Start time: '
                . $exam->exam_start_time->format('d M Y, h:i A');
        }

        if (now()->gt($exam->exam_end_time)) {
            return 'This exam has expired. End time: '
                . $exam->exam_end_time->format('d M Y, h:i A');
        }

        return null;
    }

    public function hackathons()
    {
        $hackathons = Hackathon::latest()->get();

        return view('candidate.hackathons.index', compact('hackathons'));
    }

    public function hackathonExams(Hackathon $hackathon)
    {
        if (!$this->isRegisteredForHackathon($hackathon->id)) {
            return redirect()->route('dashboard')
                ->with('error', 'Please register for this hackathon before viewing exams.');
        }

        $exams = Exam::where('hackathon_id', $hackathon->id)
            ->where('is_active', true)
            ->get();

        return view('candidate.hackathons.exams', compact('hackathon', 'exams'));
    }

    public function tokenPage(Exam $exam)
    {
        if (!$this->isRegisteredForHackathon($exam->hackathon_id)) {
            return redirect()->route('dashboard')
                ->with('error', 'Please register for this hackathon before entering token.');
        }

        $scheduleError = $this->checkExamSchedule($exam);

        if ($scheduleError) {
            return redirect()->route('dashboard')
                ->with('error', $scheduleError);
        }

        $alreadyAttempted = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->exists();

        if ($alreadyAttempted) {
            return redirect()->route('dashboard')
                ->with('error', 'You have already attempted this exam.');
        }

        return view('candidate.token', compact('exam'));
    }

    public function verifyToken(Request $request, Exam $exam)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        if (!$this->isRegisteredForHackathon($exam->hackathon_id)) {
            return redirect()->route('dashboard')
                ->with('error', 'Please register for this hackathon before verifying token.');
        }

        $scheduleError = $this->checkExamSchedule($exam);

        if ($scheduleError) {
            return redirect()->route('dashboard')
                ->with('error', $scheduleError);
        }

        $examToken = ExamToken::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->where('token', strtoupper(trim($request->token)))
            ->where('is_used', false)
            ->first();

        if (!$examToken) {
            return redirect()
                ->back()
                ->with('error', 'Invalid or already used exam token.');
        }

        session(['verified_exam_token_' . $exam->id => true]);

        return redirect()->route('candidate.exam.instructions', $exam->id)
            ->with('success', 'Token verified successfully.');
    }

    public function instructions(Exam $exam)
    {
        if (!$this->isRegisteredForHackathon($exam->hackathon_id)) {
            return redirect()->route('dashboard')
                ->with('error', 'Please register for this hackathon before starting the exam.');
        }

        $scheduleError = $this->checkExamSchedule($exam);

        if ($scheduleError) {
            return redirect()->route('dashboard')
                ->with('error', $scheduleError);
        }

        if (!$this->hasVerifiedToken($exam->id)) {
            return redirect()->route('candidate.exam.token', $exam->id)
                ->with('error', 'Please verify exam token first.');
        }

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
        if (!$this->isRegisteredForHackathon($exam->hackathon_id)) {
            return redirect()->route('dashboard')
                ->with('error', 'Please register for this hackathon before webcam verification.');
        }

        $scheduleError = $this->checkExamSchedule($exam);

        if ($scheduleError) {
            return redirect()->route('dashboard')
                ->with('error', $scheduleError);
        }

        if (!$this->hasVerifiedToken($exam->id)) {
            return redirect()->route('candidate.exam.token', $exam->id)
                ->with('error', 'Please verify exam token first.');
        }

        return view('candidate.webcam', compact('exam'));
    }

    public function start(Exam $exam)
    {
        if (!$this->isRegisteredForHackathon($exam->hackathon_id)) {
            return redirect()->route('dashboard')
                ->with('error', 'Please register for this hackathon before starting the exam.');
        }

        $scheduleError = $this->checkExamSchedule($exam);

        if ($scheduleError) {
            return redirect()->route('dashboard')
                ->with('error', $scheduleError);
        }

        if (!$this->hasVerifiedToken($exam->id)) {
            return redirect()->route('candidate.exam.token', $exam->id)
                ->with('error', 'Please verify exam token first.');
        }

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
        if (!$this->isRegisteredForHackathon($exam->hackathon_id)) {
            return redirect()->route('dashboard')
                ->with('error', 'Please register for this hackathon before submitting the exam.');
        }

        $scheduleError = $this->checkExamSchedule($exam);

        if ($scheduleError) {
            return redirect()->route('dashboard')
                ->with('error', $scheduleError);
        }

        if (!$this->hasVerifiedToken($exam->id)) {
            return redirect()->route('candidate.exam.token', $exam->id)
                ->with('error', 'Please verify exam token first.');
        }

        $alreadyAttempted = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->exists();

        if ($alreadyAttempted) {
            return redirect()->route('dashboard')
                ->with('error', 'You have already submitted this exam.');
        }

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
            'status' => $finalScore >= $exam->passing_marks
                ? 'shortlisted'
                : 'rejected',
            'submitted_at' => now(),
        ]);

        ExamToken::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->update([
                'is_used' => true,
                'used_at' => now(),
            ]);

        session()->forget('verified_exam_token_' . $exam->id);

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
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExamTokenController extends Controller
{
    public function index()
    {
        $tokens = ExamToken::with(['user', 'exam'])
            ->latest()
            ->get();

        $users = User::where('role', 'candidate')
            ->latest()
            ->get();

        $exams = Exam::latest()->get();

        return view('admin.tokens.index', compact(
            'tokens',
            'users',
            'exams'
        ));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'exam_id' => 'nullable|exists:exams,id',
        ]);

        $users = $request->user_id
            ? User::where('id', $request->user_id)->get()
            : User::where('role', 'candidate')->get();

        $exams = $request->exam_id
            ? Exam::where('id', $request->exam_id)->get()
            : Exam::latest()->get();

        if ($users->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'No candidate users found. Please create/register a candidate first.');
        }

        if ($exams->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'No exams found. Please create an exam first.');
        }

        $generatedCount = 0;

        foreach ($users as $user) {
            foreach ($exams as $exam) {

                ExamToken::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'exam_id' => $exam->id,
                    ],
                    [
                        'token' => strtoupper(Str::random(10)),
                        'is_used' => false,
                        'used_at' => null,
                    ]
                );

                $generatedCount++;
            }
        }

        return redirect()
            ->back()
            ->with('success', $generatedCount . ' exam token(s) generated/updated successfully.');
    }
}
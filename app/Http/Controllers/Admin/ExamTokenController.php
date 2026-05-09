<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamToken;
use App\Models\User;
use Illuminate\Support\Str;

class ExamTokenController extends Controller
{
    public function index()
    {
        $tokens = ExamToken::with(['user', 'exam'])
            ->latest()
            ->get();

        $users = User::where('role', 'candidate')->get();

        $exams = Exam::latest()->get();

        return view('admin.tokens.index', compact(
            'tokens',
            'users',
            'exams'
        ));
    }

    public function generate()
    {
        $users = User::where('role', 'candidate')->get();

        $exams = Exam::latest()->get();

        foreach ($users as $user) {

            foreach ($exams as $exam) {

                ExamToken::firstOrCreate([
                    'user_id' => $user->id,
                    'exam_id' => $exam->id,
                ], [
                    'token' => strtoupper(Str::random(10)),
                ]);
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Exam tokens generated successfully.');
    }
}
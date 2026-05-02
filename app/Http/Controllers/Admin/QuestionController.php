<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('exam')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $exams = Exam::all();
        return view('admin.questions.create', compact('exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required',
            'marks' => 'required|integer',
        ]);

        Question::create($request->all());

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question added successfully');
    }
}
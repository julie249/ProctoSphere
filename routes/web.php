<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Exam;
use App\Models\ExamAttempt;

Route::get('/dashboard', function () {
    $exams = Exam::where('is_active', true)->get();

    $attempts = ExamAttempt::with('exam')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('dashboard', compact('exams', 'attempts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Candidate\ExamController as CandidateExamController;
use App\Http\Controllers\ProctorController;



Route::middleware(['auth', 'admin'])->group(function () {
   Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
    Route::get('/admin/logs/{user_id}/{exam_id}', [ExamController::class, 'logs'])
    ->name('admin.logs');

    Route::get('/admin/exams', [ExamController::class, 'index'])->name('admin.exams.index');

    Route::get('/admin/exams/create', [ExamController::class, 'create'])->name('admin.exams.create');


    Route::get('/admin/leaderboard', [ExamController::class, 'leaderboard'])
    ->name('admin.leaderboard');

    Route::post('/admin/exams', [ExamController::class, 'store'])->name('admin.exams.store');
    Route::get('/candidate/exam/{id}/instructions', [CandidateExamController::class, 'instructions'])
    ->name('candidate.exam.instructions');

Route::get('/candidate/exam/{id}/start', [CandidateExamController::class, 'start'])
    ->name('candidate.exam.start.direct');

Route::post('/candidate/exam/{id}/submit', [CandidateExamController::class, 'submit'])
    ->name('candidate.exam.submit');

    Route::get('/admin/questions', [QuestionController::class, 'index'])->name('admin.questions.index');

    Route::post('/proctor/log', [ProctorController::class, 'store'])
    ->name('proctor.log');

Route::get('/admin/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');

Route::post('/admin/questions', [QuestionController::class, 'store'])->name('admin.questions.store');

Route::get('/admin/attempts', [ExamController::class, 'attempts'])
    ->name('admin.attempts');


Route::middleware(['auth'])->group(function () {
    Route::get('/candidate/exam/{id}', [CandidateExamController::class, 'start'])
        ->name('candidate.exam.start');

    Route::post('/candidate/exam/{id}/submit', [CandidateExamController::class, 'submit'])
        ->name('candidate.exam.submit');
});

});

require __DIR__.'/auth.php';

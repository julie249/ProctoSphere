<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Hackathon;

use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\HackathonController;

use App\Http\Controllers\Candidate\ExamController as CandidateExamController;

use App\Http\Controllers\ProctorController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Candidate Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $hackathons = Hackathon::where('is_active', true)->get();

    $attempts = ExamAttempt::with('exam')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('dashboard', compact('hackathons', 'attempts'));

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Candidate Exam Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/candidate/exam/{id}/instructions', [CandidateExamController::class, 'instructions'])
        ->name('candidate.exam.instructions');

    Route::get('/candidate/exam/{id}/start', [CandidateExamController::class, 'start'])
        ->name('candidate.exam.start.direct');

    Route::get('/candidate/exam/{id}', [CandidateExamController::class, 'start'])
        ->name('candidate.exam.start');

    Route::post('/candidate/exam/{id}/submit', [CandidateExamController::class, 'submit'])
        ->name('candidate.exam.submit');

    /*
    |--------------------------------------------------------------------------
    | Proctoring
    |--------------------------------------------------------------------------
    */

    Route::post('/proctor/log', [ProctorController::class, 'store'])
        ->name('proctor.log');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Exams
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/exams', [ExamController::class, 'index'])
        ->name('admin.exams.index');

    Route::get('/admin/exams/create', [ExamController::class, 'create'])
        ->name('admin.exams.create');

    Route::post('/admin/exams', [ExamController::class, 'store'])
        ->name('admin.exams.store');

    /*
    |--------------------------------------------------------------------------
    | Questions
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/questions', [QuestionController::class, 'index'])
        ->name('admin.questions.index');

    Route::get('/admin/questions/create', [QuestionController::class, 'create'])
        ->name('admin.questions.create');

    Route::post('/admin/questions', [QuestionController::class, 'store'])
        ->name('admin.questions.store');

    /*
    |--------------------------------------------------------------------------
    | Attempts & Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/attempts', [ExamController::class, 'attempts'])
        ->name('admin.attempts');

    Route::get('/admin/logs/{user_id}/{exam_id}', [ExamController::class, 'logs'])
        ->name('admin.logs');

    /*
    |--------------------------------------------------------------------------
    | Leaderboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/leaderboard', [ExamController::class, 'leaderboard'])
        ->name('admin.leaderboard');


        Route::get('/candidate/hackathon/{id}/exams', [CandidateExamController::class, 'hackathonExams'])
    ->name('candidate.hackathon.exams');
    /*
    |--------------------------------------------------------------------------
    | Hackathons
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/hackathons', [HackathonController::class, 'index'])
        ->name('admin.hackathons.index');

    Route::get('/admin/hackathons/create', [HackathonController::class, 'create'])
        ->name('admin.hackathons.create');

    Route::post('/admin/hackathons', [HackathonController::class, 'store'])
        ->name('admin.hackathons.store');
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Models\Hackathon;
use App\Models\ExamAttempt;
use App\Http\Controllers\Candidate\HackathonRegistrationController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\HackathonController;

use App\Http\Controllers\Candidate\ExamController as CandidateExamController;
use App\Http\Controllers\ProctorController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Candidate Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $hackathons = Hackathon::latest()->get();

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

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Candidate Hackathon & Exam Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/candidate/hackathons', [CandidateExamController::class, 'hackathons'])
        ->name('candidate.hackathons');

        Route::post('/hackathons/{hackathon}/register', [HackathonRegistrationController::class, 'register'])
    ->name('candidate.hackathons.register');

    Route::get('/candidate/hackathons/{hackathon}/exams', [CandidateExamController::class, 'hackathonExams'])
        ->name('candidate.hackathon.exams');

    Route::get('/candidate/exams/{exam}/instructions', [CandidateExamController::class, 'instructions'])
        ->name('candidate.exam.instructions');

    Route::get('/candidate/exams/{exam}/webcam', [CandidateExamController::class, 'webcam'])
        ->name('candidate.exam.webcam');

    Route::get('/candidate/exams/{exam}/start', [CandidateExamController::class, 'start'])
        ->name('candidate.exam.start');

    Route::post('/candidate/exams/{exam}/submit', [CandidateExamController::class, 'submit'])
        ->name('candidate.exam.submit');

    /*
    |--------------------------------------------------------------------------
    | Proctoring Routes
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
    })->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Admin Exam Routes
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
    | Admin Question Routes
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
    | Admin Hackathon Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/hackathons', [HackathonController::class, 'index'])
        ->name('admin.hackathons.index');

    Route::get('/admin/hackathons/create', [HackathonController::class, 'create'])
        ->name('admin.hackathons.create');

    Route::post('/admin/hackathons', [HackathonController::class, 'store'])
        ->name('admin.hackathons.store');

    /*
    |--------------------------------------------------------------------------
    | Attempts, Logs & Leaderboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/analytics', [ExamController::class, 'analytics'])
    ->name('admin.analytics');

    Route::get('/admin/attempts/export', [ExamController::class, 'exportAttempts'])
    ->name('admin.attempts.export');

    Route::get('/admin/attempts/export', [ExamController::class, 'exportAttempts'])
    ->name('admin.attempts.export');



    Route::get('/admin/attempts', [ExamController::class, 'attempts'])
        ->name('admin.attempts');

    Route::get('/admin/logs/{user_id}/{exam_id}', [ExamController::class, 'logs'])
        ->name('admin.logs');

    Route::get('/admin/leaderboard', [ExamController::class, 'leaderboard'])
        ->name('admin.leaderboard');
});

require __DIR__ . '/auth.php';
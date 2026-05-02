<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Exam;

class ExamAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
        'total_questions',
        'violations',
        'status',
        'started_at',
        'submitted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
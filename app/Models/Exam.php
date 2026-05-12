<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'hackathon_id',
        'title',
        'description',
        'duration',
        'total_marks',
        'passing_marks',
        'negative_marks',
        'max_warnings',
        'is_active',

        // Scheduling fields
        'exam_start_time',
        'exam_end_time',
    ];

    protected $casts = [
        'exam_start_time' => 'datetime',
        'exam_end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function tokens()
    {
        return $this->hasMany(ExamToken::class);
    }

    public function proctorLogs()
    {
        return $this->hasMany(ProctorLog::class);
    }
}
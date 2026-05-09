<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExamToken;

class Exam extends Model
{
    // Mass Assignable Fields
    protected $fillable = [
        'title',
        'description',
        'duration',
        'total_marks',
        'passing_marks',
        'negative_marks',
        'max_warnings',
        'is_active',
        'hackathon_id',

        // Scheduling Fields
        'exam_start_time',
        'exam_end_time',
    ];

    // Date Casting
    protected $casts = [
        'exam_start_time' => 'datetime',
        'exam_end_time' => 'datetime',
    ];

    // Exam belongs to Hackathon
    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }

    // Exam Tokens
    public function tokens()
    {
        return $this->hasMany(ExamToken::class);
    }
}
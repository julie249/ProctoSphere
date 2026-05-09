<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamToken extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'token',
        'is_used',
        'used_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
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
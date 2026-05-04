<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hackathon extends Model
{
    protected $fillable = [
        'title',
        'description',
        'level',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
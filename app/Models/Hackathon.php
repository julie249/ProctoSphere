<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use App\Models\HackathonRegistration;

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

    // Exams under hackathon
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // Candidate registrations
    public function registrations()
    {
        return $this->hasMany(HackathonRegistration::class);
    }
}
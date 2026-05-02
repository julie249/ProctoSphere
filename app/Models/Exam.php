<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'title',
        'description',
        'duration',
        'total_marks',
        'passing_marks',
        'negative_marks',
        'max_warnings',
        'is_active',
    ];
}
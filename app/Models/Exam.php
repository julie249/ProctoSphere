<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    // ✅ Allow mass assignment (including hackathon_id)
    protected $fillable = [
        'title',
        'description',
        'duration',
        'total_marks',
        'passing_marks',
        'negative_marks',
        'max_warnings',
        'is_active',
        'hackathon_id', // 🔥 added
    ];

    // ✅ Relationship: Exam belongs to Hackathon
    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }
}
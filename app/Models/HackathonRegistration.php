<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HackathonRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'hackathon_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }
}
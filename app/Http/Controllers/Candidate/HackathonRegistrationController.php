<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Hackathon;
use App\Models\HackathonRegistration;
use Illuminate\Http\Request;

class HackathonRegistrationController extends Controller
{
    public function register($hackathon_id)
    {
        HackathonRegistration::firstOrCreate([
            'user_id' => auth()->id(),
            'hackathon_id' => $hackathon_id,
        ], [
            'status' => 'registered',
        ]);

        return redirect()
            ->back()
            ->with('success', 'You have successfully registered for this hackathon.');
    }
}
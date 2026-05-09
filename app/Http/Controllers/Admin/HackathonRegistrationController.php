<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackathonRegistration;

class HackathonRegistrationController extends Controller
{
    public function index()
    {
        $registrations = HackathonRegistration::with(['user', 'hackathon'])
            ->latest()
            ->get();

        return view('admin.registrations.index', compact('registrations'));
    }
}
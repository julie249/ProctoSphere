<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hackathon;

class HackathonController extends Controller
{
    // Show all hackathons
    public function index()
    {
        $hackathons = Hackathon::latest()->get();
        return view('admin.hackathons.index', compact('hackathons'));
    }

    // Show create form
    public function create()
    {
        return view('admin.hackathons.create');
    }

    // Store hackathon
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        Hackathon::create([
            'title' => $request->title,
            'description' => $request->description,
            'level' => $request->level ?? 'national',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => 1,
        ]);

        return redirect()->route('admin.hackathons.index')
            ->with('success', 'Hackathon created successfully');
    }
}
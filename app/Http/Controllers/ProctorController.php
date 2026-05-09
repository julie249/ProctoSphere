<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProctorLog;
use Illuminate\Support\Facades\Auth;

class ProctorController extends Controller
{
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'event_type' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Store Proctor Log
        |--------------------------------------------------------------------------
        */

        $log = ProctorLog::create([
            'user_id' => Auth::id(),
            'exam_id' => $request->exam_id,
            'event_type' => $request->event_type,
            'details' => $request->details,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Return Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Proctor log saved successfully',
            'log' => $log,
        ]);
    }
}
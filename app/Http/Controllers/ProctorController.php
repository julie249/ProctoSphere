<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProctorLog;
use Illuminate\Support\Facades\Auth;

class ProctorController extends Controller
{
    public function store(Request $request)
    {
        ProctorLog::create([
            'user_id' => Auth::id(),
            'exam_id' => $request->exam_id,
            'event_type' => $request->event_type,
            'details' => $request->details,
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
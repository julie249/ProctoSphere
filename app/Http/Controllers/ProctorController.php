<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProctorLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProctorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'event_type' => 'required|string|max:255',
            'details' => 'nullable|string',
            'snapshot' => 'nullable|string',
        ]);

        $snapshotPath = null;

        if ($request->snapshot) {
            $image = $request->snapshot;

            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            $imageName = 'violation_' . Auth::id() . '_' . time() . '.png';
            $snapshotPath = 'violations/' . $imageName;

            Storage::disk('public')->put($snapshotPath, base64_decode($image));
        }

        $log = ProctorLog::create([
            'user_id' => Auth::id(),
            'exam_id' => $request->exam_id,
            'event_type' => $request->event_type,
            'details' => $request->details,
            'snapshot' => $snapshotPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proctor log saved successfully',
            'log' => $log,
        ]);
    }
}
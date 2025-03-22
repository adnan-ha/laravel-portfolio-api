<?php

namespace App\Http\Controllers\Api;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences = Experience::all();

        if ($experiences->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }
        return response()->json(['experiences' => $experiences]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string',
            'company' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $experience = Experience::create([
            'job_title' => $request->job_title,
            'company' => $request->company,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'experience was created successfully', 'experience' => $experience], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $experience = Experience::find($id);
        if (!$experience) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $request->validate([
            'job_title' => 'string',
            'company' => 'string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $experience->update([
            'job_title' => $request->job_title ?? $experience->job_title,
            'company' => $request->company ?? $experience->company,
            'start_date' => $request->start_date ?? null,
            'end_date' => $request->end_date ?? null,
            'description' => $request->description ?? null,
        ]);
        return response()->json(['message' => 'experience updated successfully', 'experience' => $experience]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $experience = Experience::find($id);
        if (!$experience) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $experience->delete();
        return response()->json(['message' => 'experience was deleted successfully']);
    }
}

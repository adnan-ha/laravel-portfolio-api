<?php

namespace App\Http\Controllers\Api;

use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = Education::all();

        if ($education->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }
        return response()->json(['education' => $education]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'field_of_study' => 'required|string',
            'institution' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $education = Education::create([
            'field_of_study' => $request->field_of_study,
            'institution' => $request->institution,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json(['message' => 'created successfully', 'education' => $education], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $education = Education::find($id);
        if (!$education) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $request->validate([
            'field_of_study' => 'string',
            'institution' => 'string',
            'description' => 'nullable|string',
            'start_date' => 'date',
            'end_date' => 'nullable|date',
        ]);

        $education->update([
            'field_of_study' => $request->field_of_study ?? $education->field_of_study,
            'institution' => $request->institution ?? $education->institution,
            'description' => $request->description ?? null,
            'start_date' => $request->start_date ?? $education->start_date,
            'end_date' => $request->end_date ?? null,
        ]);
        return response()->json(['message' => 'education updated successfully', 'education' => $education]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $education = Education::find($id);
        if (!$education) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $education->delete();
        return response()->json(['message' => 'education was deleted successfully']);
    }
}

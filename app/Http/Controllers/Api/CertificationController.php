<?php

namespace App\Http\Controllers\Api;

use App\Models\Certification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificationController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certifications = Certification::all();

        if ($certifications->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }
        return response()->json(['certifications' => $certifications]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'organization' => 'required|string',
            'issued_date' => 'nullable|date',
            'certification_url' => 'nullable|url',
        ]);

        $certification = Certification::create([
            'name' => $request->name,
            'organization' => $request->organization,
            'issued_date' => $request->issued_date,
            'certification_url' => $request->certification_url,
        ]);

        return response()->json(['message' => 'certification was created successfully', 'certification' => $certification], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $certification = Certification::find($id);
        if (!$certification) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'organization' => 'required|string',
            'issued_date' => 'nullable|date',
            'certification_url' => 'nullable|url',
        ]);

        $certification->update([
            'name' => $request->name ?? $certification->name,
            'organization' => $request->organization ?? $certification->organization,
            'issued_date' => $request->issued_date ?? null,
            'certification_url' => $request->certification_url ?? null,
        ]);
        return response()->json(['message' => 'certification updated successfully', 'certification' => $certification]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $certification = Certification::find($id);
        if (!$certification) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $certification->delete();
        return response()->json(['message' => 'certification was deleted successfully']);
    }
}

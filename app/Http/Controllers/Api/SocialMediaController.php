<?php

namespace App\Http\Controllers\Api;

use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialMedia = SocialMedia::all();
        if ($socialMedia->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }

        return response()->json(['socialMedia' => $socialMedia]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string',
            'link' => 'required|url',
        ]);

        $data = SocialMedia::create([
            'platform' => $request->platform,
            'link' => $request->link,
        ]);

        return response()->json(['message' => 'socialMedia was created successfully', 'data' => $data], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $socialMedia = SocialMedia::find($id);
        if (!$socialMedia) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $data = $request->validate([
            'platform' => 'string',
            'link' => 'url',
        ]);

        $socialMedia->update($data);
        return response()->json(['message' => 'socialMedia updated successfully', 'data' => $socialMedia]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $socialMedia = SocialMedia::find($id);
        if (!$socialMedia) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $socialMedia->delete();
        return response()->json(['message' => 'socialMedia was deleted successfully']);
    }
}

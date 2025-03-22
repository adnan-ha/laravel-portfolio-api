<?php

namespace App\Http\Controllers\Api;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();

        if ($skills->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }
        return response()->json(['skills' => $skills]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'proficiency' => 'required|integer|min:0|max:100',
        ]);

        $skill = Skill::create([
            'name' => $request->name,
            'proficiency' => $request->proficiency,
        ]);

        return response()->json(['message' => 'skill was created successfully', 'skill' => $skill], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $skill = Skill::find($id);
        if (!$skill) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $data = $request->validate([
            'name' => 'string',
            'proficiency' => 'integer|min:0|max:100',
        ]);

        $skill->update($data);
        return response()->json(['message' => 'skill updated successfully', 'skill' => $skill]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skill = Skill::find($id);
        if (!$skill) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $skill->delete();
        return response()->json(['message' => 'skill was deleted successfully']);
    }
}

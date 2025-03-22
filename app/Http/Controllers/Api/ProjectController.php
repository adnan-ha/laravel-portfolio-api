<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        if ($projects->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }

        $data = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'image' => $project->image_url,
                'link' => $project->link,
            ];
        });
        return response()->json(['projects' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'link' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg',
        ]);

        $imageName = $request->file('image')->store('images/projects', 'public');

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'image' => $imageName,
        ]);

        return response()->json(['message' => 'project was created successfully', 'project' => $project], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $data = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'link' => 'url',
            'image' => 'image|mimes:jpeg,png,jpg,svg',
        ]);

        if ($request->hasFile('image')) {
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }
            $imageName = $request->file('image')->store('images/projects', 'public');
            $data['image'] = $imageName;
        }

        $project->update($data);
        return response()->json(['message' => 'project updated successfully', 'project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $project->delete();

        if ($project->image && Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        return response()->json(['message' => 'project was deleted successfully']);
    }
}

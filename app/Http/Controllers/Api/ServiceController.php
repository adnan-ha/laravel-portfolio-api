<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }
        return response()->json(['services' => $services]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $service = Service::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'service was created successfully', 'service' => $service], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $data = $request->validate([
            'title' => 'string',
            'description' => 'string',
        ]);

        $service->update($data);
        return response()->json(['message' => 'service updated successfully', 'service' => $service]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $service->delete();
        return response()->json(['message' => 'service was deleted successfully']);
    }
}

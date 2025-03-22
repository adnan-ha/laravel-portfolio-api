<?php

namespace App\Http\Controllers\Api;

use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactRequestController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ContactRequests = ContactRequest::all();

        if ($ContactRequests->isEmpty()) {
            return response()->json(['message' => 'no data was found'], 404);
        }
        return response()->json(['ContactRequests' => $ContactRequests]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'nullable|string',
            'message' => 'required|string',
        ]);

        $ContactRequest = ContactRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json(['message' => 'Contact request created successfully.', 'ContactRequest' => $ContactRequest], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ContactRequest = ContactRequest::find($id);
        if (!$ContactRequest) {
            return response()->json(['message' => 'Invalid ID'], 404);
        }

        $ContactRequest->delete();
        return response()->json(['message' => 'ContactRequest was deleted successfully']);
    }
}

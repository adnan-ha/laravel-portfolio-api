<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = User::first();

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $user->bio,
            'address' => $user->address,
            'photo' => $user->image_url,
            'birthdate' => $user->birthdate,
            'phone_number' => $user->phone_number,
            'specialization' => $user->specialization,
        ];

        return response()->json(['user' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::first();

        $request->validate([
            'name' => 'string',
            'email' => 'email',
            'password' => 'confirmed',
            'bio' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'birthdate' => 'nullable|date',
            'phone_number' => 'nullable|string',
            'specialization' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoName = $request->file('photo')->store('images/user', 'public');
        } else {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'bio' => $request->bio ?? null,
            'address' => $request->address ?? null,
            'photo' => $photoName ?? null,
            'birthdate' => $request->birthdate ?? null,
            'phone_number' => $request->phone_number ?? null,
            'specialization' => $request->specialization ?? null,
        ]);
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
}

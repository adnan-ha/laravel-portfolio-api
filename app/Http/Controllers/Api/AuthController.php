<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        $data = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        return response()->json(['user' => $data, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'logged out'], 200);
    }
}

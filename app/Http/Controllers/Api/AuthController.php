<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'provided credentials are invalid.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => 'provided credentials are invalid.']);
        }

        $tokenName = 'user-' . $user->id . '-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            $tokenName => $token,
        ]);
    }

    public function logout(Request $request) {
        
    }
}

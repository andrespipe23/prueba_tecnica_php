<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Los datos de acceso no son correctos.',
                'success' => false
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api_token')->plainTextToken;

        $user->tokens()->latest()->first()->update([
            'expires_at' => now()->addHour()
        ]);

        return response()->json([
            'type' => "Bearer",
            'token' => $token
        ], 201);
    }

    public function register(UserStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente.',
            'success' => true
        ], 201);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada.',
            'success' => true
        ], 200);
    }
}

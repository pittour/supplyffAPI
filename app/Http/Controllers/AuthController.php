<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $post_data = $request->validate([
            'username' => 'required|string|min:3|max:12',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed|min:8|max:12',
            'ingame_tag' => 'required|string|min:2|max:16',
            'server_id' => 'required',
        ]);

        $user = User::create($request->except(['password_confirmation', 'password']) + ['password' => Hash::make($post_data['password'])]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();
        return [
            'message' => 'User successfully logged out'
        ];
    }

    public function me()
    {
        $user = auth()->user();
        $server = $user->server;

        return compact('user', 'server');
    }
}

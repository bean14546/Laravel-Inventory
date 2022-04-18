<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        // validate field
        $fields = $request->validate([
            'fullname' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'tel' => 'required|string',
            'role' => 'required|string|integer',
        ]);

        // Create user
        $user = User::create([
            'fullname' => $fields['fullname'],
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'tel' => $fields['tel'],
            'role' => $fields['role'],
        ]);

        // Create token
        $token = $user->createToken($request->userAgent(),["$user->role"])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        // validate field
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            $response = [
                'status' => 'error',
                'message' => 'Invalid email or password',
            ];
            return response($response, 401);
        } else {
            // Delete old token
            $user->tokens()->delete();

            // Create token
            $token = $user->createToken($request->userAgent(),["$user->role"])->plainTextToken;
            $response = [
                'status' => 'success',
                'message' => 'Welcome '.$user->fullname,
                'user' => $user,
                'token' => $token,
            ];
            return response($response, 200);
        }

    }

    public function logout(){
        auth()->user()->tokens()->delete();
        $response = [
            'status' => 'success',
            'message' => 'Logged out'
        ];
        return response($response,200);
    }

    
}

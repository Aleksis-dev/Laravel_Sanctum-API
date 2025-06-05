<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|unique:users|max:255",
            "password" => "required|confirmed|min:8|max:255"
        ]);

        $hashedPassword = Hash::make($request->input("password"));

        $user = User::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => $hashedPassword
        ]);

        $token = $user->createToken("token")->plainTextToken;

        return response()->json([
            "user" => $user,
            "token" => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists|max:255",
            "password" => "required|min:8|max:255"
        ]);

        $user = User::where("email", $request->input("email"))->first();

        if ($user && Hash::check($request->input("password"), $user->password)) {
            $token = $user->createToken("token")->plainTextToken;

            return response()->json([
                "user" => $user,
                "token" => $token,
                "message" => "Successfully logged in as " . $user->name
            ], 200);
        } else {
            return response()->json([
                "message" => "Invalid credentials!"
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        
    }
}

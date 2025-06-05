<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|unique:users|max:255",
            "password" => "required|confirmed|min:8|max:255"
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists|max:255",
            "password" => "required|min:8|max:255"
        ]);
    }

    public function logout(Request $request)
    {
        
    }
}

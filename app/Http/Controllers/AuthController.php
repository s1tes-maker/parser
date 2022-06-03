<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'login' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['login'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        $token = $user->CreateToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function login(Request $request) {

        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credentials)) {
            return response()->json(['status'=>200, 'body'=>['value'=>Auth::user()->getRememberToken()]]);
        }
        return response()->json(['status'=>401]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthControllers extends Controller
{
    public function register(Request $request){
        $registerUserData = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8',
            'role_id' => 'required|exists:roles,id',

        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
            'role_id' => $registerUserData['role_id'],

        ]);
        return response()->json([
            'message' => 'User Created ',
            'user' => $user,
        ]);
    }
    public function login(Request $request){

        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8',

        ]);

        if(!$token = auth()->attempt($loginUserData)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        return response()->json([
            'message' => 'Logged In',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60 * 60,
            'user' => auth()->user(),
        ],200);

    }
    public function logout(){
        
        auth()->logout();
        
        return response()->json([
            'message' => 'Logged Out'
        ]);
    }
}

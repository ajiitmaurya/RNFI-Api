<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as UserModel;

class UserController extends Controller
{

    public function register(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);
        \Log::info($request->all());
        $response = UserModel::registerUser($request->all());
        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
       $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);
        $authUserData = UserModel::loginUser($request->all());

        if(empty($authUserData)){
          return  response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json($authUserData);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAccountCreatingRequest;
use App\Http\Requests\UserLogInRequest;
use App\Models\Users\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserAccountCreatingRequest $request)
    {

        $user = User::create($request->all());
        return response()->json(['token' => $user->createToken('API Token')->plainTextToken]);
    }

    public function login(UserLogInRequest $request)
    {

        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'message'=>'wrong credentials'
            ]);
        }
        return response()->json(['token' => auth()->user()->createToken('API Token')->plainTextToken]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAccountCreatingRequest;
use App\Http\Requests\UserLogInRequest;
use App\Models\Users\Address;
use App\Models\Users\User;
use App\Models\Users\Username;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $helper;

    public function register(UserAccountCreatingRequest $request): \Illuminate\Http\JsonResponse
    {
        $request = collect($request);
        $user_info = $this->helper->filter($request, ['name', 'email', 'password', 'birth_date']);
        $user_info['password'] = bcrypt($user_info['password']);
        $user = User::create($user_info);
        $user->username()->save(new Username(['name' => $this->helper->filter($request, ['username'])['username']]));
        $user->address()->save(new Address($this->helper->filter($request, ['town', 'city'])));
        return response()->json([
            'token' => $user->createToken('API Token')->plainTextToken,
            'id' => $user->id]);
    }

    public function login(UserLogInRequest $request): \Illuminate\Http\JsonResponse
    {

        if (!Auth::attempt($request->only('email', 'password'))) {

            return response()->json([
                'message' => 'wrong credentials'
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAccountCreatingRequest;
use App\Http\Requests\UserLogInRequest;
use App\Models\Users\Address;
use App\Models\Users\User;
use App\Models\Users\Username;
use http\Env\Request;
use http\Env\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $helper;

    public function register(UserAccountCreatingRequest $request)
    {

        $request = collect($request);

        $user_info = $this->helper->filter($request, ['name', 'email', 'password', 'birth_date']);

        $user_info['password'] = bcrypt($user_info['password']);
        $user_info['birth_date'] = Carbon::parse($request['birth_date']);
        $user = User::create($user_info);
        $user->birth_date = Carbon::parse($request['birth_date']);
        $user->save();
        $user->username()->save(new Username(['name' => $this->helper->filter($request, ['username'])['username']]));
        if ($request->get('city') && $request->get('town'))
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
        return response()->json(['token' => auth()->user()->createToken('API Token')->plainTextToken, 'id' => auth()->user()->id]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
    public function changePassword()
    {
        $user = User::find(\auth()->user()->getAuthIdentifier());
        $newCryptedPassword=bcrypt(\request()->newPassword);
        $user->password=$newCryptedPassword;
        $user->save();
        auth()->user()->tokens()->delete();
        return response()->json([
            'token' => $user->createToken('API Token')->plainTextToken,
            'id' => $user->id]);
    }
}

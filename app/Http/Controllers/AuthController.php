<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAccountCreatingRequest;
use App\Http\Requests\UserLogInRequest;
use App\Models\Photo;
use App\Models\Users\Address;
use App\Models\Users\User;
use App\Models\Users\Username;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $helper;

    public function register(UserAccountCreatingRequest $request)
    {
        $request = collect($request);
        $user_info = $this->helper->filter($request, ['name', 'email', 'password', 'birth_date']);
        $user_info['password'] = bcrypt($user_info['password']);
        $user_info['birth_date'] = '1999-14-09';
        $user = User::create($user_info);
        $user->username()->save(new Username(['name' => $this->helper->filter($request, ['username'])['username']]));
        if ($request->get('city') && $request->get('town'))
            $user->address()->save(new Address($this->helper->filter($request, ['town', 'city'])));
        $this->createUserDefaultPic($user);
        $this->createUserDefaultCoverPic($user);
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
        $token =  auth()->user()->createToken('API Token')->plainTextToken;
        $user = User::find(auth()->user()->id);
        return response()->json([
            'token' => $token,
            'id'=>auth()->user()->id,
            'userName'=>$user->name,
            'profilePic'=>$user->photo()->where('photo_type','=','profile')->where('current','=','1')->first()->url,
        ]);
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
    private function createUserDefaultPic($user){
        $profilePic = new Photo();
        $profilePic->url = 'https://oneaddressfashion.com/profilePic/social-network.jpg';
        $profilePic->photo_type = 'profile';
        $profilePic->current = 1;
        $user->photo()->save($profilePic);
    }
    private function createUserDefaultCoverPic($user){
        $coverPic = new Photo();
        $coverPic->url = 'https://oneaddressfashion.com/coverPic/cover_social.png';
        $coverPic->photo_type = 'cover';
        $coverPic->current = 1;
        $user->photo()->save($coverPic);
    }
}

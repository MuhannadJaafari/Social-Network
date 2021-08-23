<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        $crd = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($crd);

        return ['sent'];
    }

    public function reset()
    {

        $crd = request()->validate(['email' => 'required|email',
            'password' => 'required|string|max:25',
            'token' => 'required|string']);
        $status = Password::reset($crd, function ($user, $password) {

            $user->password = bcrypt($password);
            $user->save();
        });
        if ($status == Password::INVALID_TOKEN) {
            return ['invalid token'];
        }
        return ['password changed'];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function getGoogleAuth()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function authGoogleCallback()
    {
        $gUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $gUser->email)->first();
        if ($user == null) {
            $user = $this->createUserByGoogle($gUser);
        }
        \Auth::login($user, true);
        return redirect('/');
    }

    public function createUserByGoogle($gUser)
    {
        $user = User::create([
            'name'     => $gUser->name,
            'email'    => $gUser->email,
            'password' => \Hash::make(uniqid()),
            'role' => 1,
            'email_verified_at' => now(),
        ]);
        return $user;
    }
}
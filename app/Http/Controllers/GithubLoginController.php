<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubLoginController extends Controller
{
    public function getGithubAuth()
    {
        return Socialite::driver('github')
            ->redirect();
    }

    public function authGithubCallback()
    {
        $gUser = Socialite::driver('github')->stateless()->user();
        $user = User::where('email', $gUser->email)->first();
        if ($user == null) {
            $user = $this->createUserByGithub($gUser);
        }
        \Auth::login($user, true);
        return redirect('/');
    }

    public function createUserByGithub($gUser)
    {
        $user = User::create([
            'name'     => $gUser->nickname,
            'email'    => $gUser->email,
            'password' => \Hash::make(uniqid()),
            'role' => 1,
            'email_verified_at' => now(),
        ]);
        return $user;
    }
}

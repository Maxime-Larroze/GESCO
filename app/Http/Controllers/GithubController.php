<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GithubController extends Controller
{
    /**
     * function to redirect to Google Auth.
     *
     * @return void
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * function to login or register with google.
     *
     * @return void
     */
    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
            $userFounded = User::updateOrCreate(
                ['email' =>  $user->user['email']],
                [
                    'firstname' => $user->user['login'],
                    'lastname' => '',
                    'email' => $user->user['email'],
                    'picture' => $user->user['avatar_url'],
                ]
            );
            Auth::login($userFounded, true);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('home');
        }
    }

    /**
     * function to Auto Login.
     *
     * @return void
     */
    public function autoLogin()
    {
        if (Auth::viaRemember()) {
            return redirect()->route('dashboard');
        } else {
            return view('public.login');
        }
    }
}

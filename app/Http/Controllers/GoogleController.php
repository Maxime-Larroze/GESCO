<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * function to redirect to Google Auth.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * function to login or register with google.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $userFounded = User::updateOrCreate(
                ['email' =>  $user->user['email']],
                [
                    'firstname' => $user->user['given_name'],
                    'lastname' => $user->user['family_name'],
                    'email' => $user->user['email'],
                    'picture' => $user->user['picture'],
                ]
            );
            Auth::login($userFounded, true);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
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

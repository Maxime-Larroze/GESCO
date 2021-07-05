<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    /**
     * function to redirect to Google Auth.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * function to login or register with google.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $userFounded = User::updateOrCreate(
                ['email' =>  $user->user['email']],
                [
                    'firstname' => $user->user['name'],
                    'lastname' => '',
                    'email' => $user->user['email'],
                    'picture' => $user->avatar_original,
                ]
            );
            Auth::login($userFounded, true);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            return redirect()->route('home');
        }
    }
}

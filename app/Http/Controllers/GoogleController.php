<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    /**
     * function to redirect to Google Auth.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        Log::info("Connexion via Google");
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
            Log::info("Connexion via Google ".Auth::user()->id);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            Log::critical("Erreur de connexion Github: ".$e);
            return redirect()->route('home')->withErrors(['error'=>"Impossible de vous connecter. Veuillez vérifier votre identifiant / mot de passe"]);
        }
    }
}

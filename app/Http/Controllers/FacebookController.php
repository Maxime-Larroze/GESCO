<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        Log::info("Tentative de connexion via facebook");
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
            Log::info("Connexion via facebook ".Auth::user()->id);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            Log::critical("Erreur de connexion Facebook: ".$e);
            return redirect()->route('home')->withErrors(['error'=>"Impossible de vous connecter. Veuillez vérifier votre identifiant / mot de passe"]);
        }
    }
}

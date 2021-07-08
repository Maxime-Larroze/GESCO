<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GithubController extends Controller
{
    /**
     * function to redirect to Google Auth.
     *
     * @return void
     */
    public function redirectToGithub()
    {
        Log::info("Tentative de connexion via Github");
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
            Log::info("Connexion via Github ".Auth::user()->id);
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            Log::critical("Erreur de connexion Github: ".$e);
            return redirect()->route('home')->withErrors(['error'=>"Impossible de vous connecter. Veuillez vérifier votre identifiant / mot de passe"]);
        }
    }
}

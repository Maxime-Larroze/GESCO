<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;
use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class DashboardController extends Controller
{
    public function DashboardView()
    {
        $user = Auth::user();
        return view('auth.dashboard', ['user' => $user]);
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function Login(Request $request)
    {
        request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($request->remember == 'on') {
            $request->remember = true;
        } else {
            $request->remember = false;
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->email], $request->remember)) {
            Log::info("Connexion de l'utilisateur " . Auth::user()->id . " le " . Carbon::now());
            $user = Auth::user();
            return redirect()->route('dashboard');
        }
        redirect()->route('home')->withError(['connexion' => 'Connexion impossible. Veuillez vérifier votre identifiant / mot de passe']);
    }
}

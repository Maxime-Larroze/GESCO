<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Organisation;
use App\Models\Parametre;
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
    public function dashboardView()
    {
        try {
            $user = Auth::user();
            if(!$user){redirect()->route('home');}

            Log::notice("consultation dashboard - utilisateur id: ".$user->id);
            $endMissions = Mission::where('ended_at', '!=', null)->where('user_id', $user->id)->get();
            $MissionEnCours = Mission::where('ended_at', null)->where('user_id', $user->id)->get();
            $nbMissionTermine = count($endMissions);
            $nbMissionEnCours = count($MissionEnCours);
            $organisations = Organisation::where('user_id', $user->id)->get();
            $parametre = Parametre::where('user_id', $user->id)->first();
            return view('auth.dashboard.interface', ['user' => $user, 'nbMissionEnCours'=>$nbMissionEnCours, 'nbMissionTermine'=>$nbMissionTermine, 
            'endMissions'=>$endMissions, 'MissionEnCours'=>$MissionEnCours, 'organisations'=>$organisations, 'parametre'=>$parametre]);
        } catch (\Throwable $th) {
            return back()->withErrors(['error'=>"une erreur est survenue: "+$th]);
        }
    }

    public function logout(Request $request)
    {
        try {
            Log::info("déconnexion de l'utilisateur id: ".Auth::user()->id);
            Auth::logout();
            Session()->flush();
            return redirect()->route('home')->withErrors(['validate'=>"Vous avez bien été déconnecté de l'application"]);
        } catch (\Throwable $th) {
            return redirect()->route('home')->withErrors(['error'=>"une erreur est survenue: ".$th]);
        }
    }

    /**
     * function to Auto Login.
     *
     * @return void
     */
    public function autoLogin()
    {
        try{
            if (!empty(Auth::viaRemember()) && Auth::viaRemember()) {
                return redirect()->route('dashboard');
            } else {
                return view('public.login');
            }
        } catch (\Throwable $th) {
            return view('public.login');
        }
    }
}
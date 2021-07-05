<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Organisation;
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
        $nbMissionTermine = count(Mission::where('ended_at', '!=', null)->get());
        $nbMissionEnCours = count(Mission::where('ended_at', null)->get());
        $endMissions = Mission::where('ended_at', '!=', null)->get();
        $MissionEnCours = Mission::where('ended_at', '!=', null)->get();
        $organisations = Organisation::all();
        return view('auth.dashboard.interface', ['user' => $user, 'nbMissionEnCours'=>$nbMissionEnCours, 'nbMissionTermine'=>$nbMissionTermine, 
        'endMissions'=>$endMissions, 'MissionEnCours'=>$MissionEnCours, 'organisations'=>$organisations]);
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Mission;
use App\Models\Organisation;
use App\Models\Parametre;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboardView()
    {
        try {
            $user = Auth::user();
            if(!$user){redirect()->route('home');}

            $transactions = Transaction::where('user_id',$user->id)->where('payed_at', '>=', Carbon::now()->submonths(12))->get();
            $transactions6 = 0;
            $transactions12 = 0;
            $nbtransactions = count($transactions);

            $contributions = Contribution::where('user_id',$user->id)->where('updated_at', '>=', Carbon::now()->submonths(12))->get();
            $contributions6 = 0;
            $contributions12 = 0;
            $nbcontributions = count($contributions);

            Log::notice("consultation dashboard - utilisateur id: ".$user->id);
            $endMissions = Mission::where('ended_at', '!=', null)->where('user_id', $user->id)->get();
            $MissionEnCours = Mission::where('ended_at', null)->where('user_id', $user->id)->get();
            $nbMissionTermine = count($endMissions);
            $nbMissionEnCours = count($MissionEnCours);
            $organisations = Organisation::where('user_id', $user->id)->get();
            $parametre = Parametre::where('user_id', $user->id)->first();

            foreach($transactions as $transaction)
            {
                if($transaction->payed_at >= Carbon::now()->submonths(6))
                {
                    $transactions6+=$transaction->price;
                }
                if($transaction->payed_at >= Carbon::now()->submonths(12))
                {
                    $transactions12+=$transaction->price;
                }
            }

            foreach($contributions as $contribution)
            {
                if($contribution->updated_at >= Carbon::now()->submonths(6))
                {
                    $contributions6+=$contribution->price;
                }
                if($contribution->updated_at >= Carbon::now()->submonths(12))
                {
                    $contributions12+=$contribution->price;
                }
            }

            return view('auth.dashboard.interface', ['user' => $user, 'nbMissionEnCours'=>$nbMissionEnCours, 'nbMissionTermine'=>$nbMissionTermine, 
                'endMissions'=>$endMissions, 'MissionEnCours'=>$MissionEnCours, 'organisations'=>$organisations, 'parametre'=>$parametre,
                'nbtransactions'=>$nbtransactions, 'transactions6'=>$transactions6, 'transactions12'=>$transactions12,
                'nbcontributions'=>$nbcontributions, 'contributions6'=>$contributions6, 'contributions12'=>$contributions12,
            ]);
        } catch (\Throwable $th) {
            Log::error("Dashboard::dashboardView: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue: ".$th]);
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
            Log::error("Dashboard::logout: ".$th);
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
            $remember = Auth::viaRemember();
            if (!empty($remember) && $remember) {
                return redirect()->route('dashboard');
            } else {
                return view('public.login');
            }
        } catch (\Throwable $th) {
            Log::error("Dashboard::logout: ".$th);
            return view('public.login');
        }
    }

    public function error404()
    {
        Log::critical("Dashboard::404");
        return view('errors.404');
    }

    public function error403()
    {
        Log::critical("Dashboard::403");
        return view('errors.403');
    }
}
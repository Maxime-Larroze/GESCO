<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLine;
use Illuminate\Http\Request;
use App\Models\Organisation;
use App\Models\Parametre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $this->validate($request, [
                'organisation_id' => 'required',
                'title' => 'required',
            ]);
            $organisation = Organisation::find($request->organisation_id);
            if(!empty($request->comment))
            {
                Mission::create([
                        'reference' => Uuid::uuid4(),
                        'organisation_id' => $request->organisation_id,
                        'title' => $request->title,
                        'comment' => $request->comment,
                        'deposit' => 0,
                        'user_id'=>Auth::user()->id,
                ]);
            }
            else{
                Mission::create([
                        'reference' => Uuid::uuid4(),
                        'organisation_id' => $request->organisation_id,
                        'title' => $request->title,
                        'deposit' => 0,
                        'user_id'=>Auth::user()->id,
                ]);
            }
            Log::notice("Création d'une mission pour l'organisation ".$organisation->id);
            return redirect()->route('missions.show')->withErrors(['validate'=>'Créationde la mission avec succès']);
        } catch (\Throwable $th) {
            Log::error("Mission::create: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function show(Mission $mission)
    {
        return view('auth.mission.interface', ['organisations' => Organisation::where('user_id', Auth::user()->id)->get(), 
        'user' => Auth::user(), 'missions' => Mission::where('user_id', Auth::user()->id)->get(), 
        "missionLines" => MissionLine::where('user_id', Auth::user()->id)->get(), 'parametre'=>Parametre::where('user_id', Auth::user()->id)->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function edit(Mission $mission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $taux = Crypt::decryptString(Parametre::where('user_id', Auth::user()->id)->first()->taux_accompte);
            $depot = 0;
            MissionLine::where("mission_id", $request->mission_id)->where('user_id', Auth::user()->id)->delete();
            if(!empty($request->title_missionline_A))
            {
                $this->validate($request, [
                    'title_missionline_A' => 'required',
                    'mission_id' => 'required',
                    'quantity_missionline_A' => 'required',
                    'price_missionline_A' => 'required',
                    'unity_missionline_A' => 'required',
                    'title' => 'required',
                ]);
                for ($i=0; $i < count($request->title_missionline_A); $i++) { 
                    if(!empty($request->title_missionline_A[$i]))
                    {
                        try{
                            MissionLine::create([
                                'mission_id'=>$request->mission_id,
                                'title'=>$request->title_missionline_A[$i],
                                'quantity'=>$request->quantity_missionline_A[$i],
                                'price'=>$request->price_missionline_A[$i],
                                'unity'=>$request->unity_missionline_A[$i],
                                'user_id'=>Auth::user()->id,
                            ]);
                            $depot += $request->quantity_missionline_A[$i] * $request->price_missionline_A[$i];
                            Log::notice("Création d'une missionLine pour la mission ".$request->mission_id);
                        } catch (\Throwable $th) {
                            Log::error("Mission::update: ".$th);
                            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
                        }
                    }
                }
            }
            if(!empty($request->title_missionline_B))
            {
                $this->validate($request, [
                    'title_missionline_B' => 'required',
                    'mission_id' => 'required',
                    'quantity_missionline_B' => 'required',
                    'price_missionline_B' => 'required',
                    'unity_missionline_B' => 'required',
                ]);
                for ($j=0; $j < count($request->title_missionline_B); $j++) { 
                    if(!empty($request->title_missionline_B[array_keys($request->title_missionline_B)[$j]]))
                    {
                        try{
                            MissionLine::create([
                                'mission_id'=>$request->mission_id,
                                'title'=>$request->title_missionline_B[array_keys($request->title_missionline_B)[$j]],
                                'quantity'=>$request->quantity_missionline_B[array_keys($request->title_missionline_B)[$j]],
                                'price'=>$request->price_missionline_B[array_keys($request->title_missionline_B)[$j]],
                                'unity'=>$request->unity_missionline_B[array_keys($request->title_missionline_B)[$j]],
                                'user_id'=>Auth::user()->id,
                            ]);
                            $depot += $request->price_missionline_B[array_keys($request->title_missionline_B)[$j]] * $request->quantity_missionline_B[array_keys($request->title_missionline_B)[$j]];
                            Log::notice("Création/Modification d'une missionLine pour la mission ".$request->mission_id);
                        } catch (\Throwable $th) {
                            Log::error("Mission::update: ".$th);
                            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
                        }
                    }
                }
            }
            if(empty($request->ended_at) && !isset($request->ended_at))
            {
                try{
                    Mission::find($request->mission_id)->update(['ended_at'=>null]);
                    Log::notice("Suppression d'une date fin de mission pour la mission ".$request->mission_id);
                } catch (\Throwable $th) {
                    Log::error("Mission::update: ".$th);
                    return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
                }
            }
            else
            {
                try{
                    Mission::find($request->mission_id)->update(['ended_at'=>Carbon::now()]);
                } catch (\Throwable $th) {
                    Log::error("Mission::update: ".$th);
                    return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
                }
            }
            // dd(Mission::find($request->mission_id)->ended_at);

            try{
                if(!empty($request->comment))
                {
                    Mission::find($request->mission_id)->update([
                            'organisation_id' => $request->organisation_id,
                            'title' => $request->title,
                            'comment' => $request->comment,
                            'deposit'=>$depot*$taux??45/100,
                    ]);
                }
                else{
                    Mission::find($request->mission_id)->update([
                            'organisation_id' => $request->organisation_id,
                            'title' => $request->title,
                            'deposit'=>$depot*$taux??45/100,
                            'comment' => null,

                    ]);
                }
                if(!empty($request->signed_at)){Mission::find($request->mission_id)->update(['signed_at' => $request->signed_at]);}
                else{Mission::find($request->mission_id)->update(['signed_at' => null]);}
                if(!empty($request->deposed_at)){Mission::find($request->mission_id)->update(['deposed_at' => $request->deposed_at]);}
                else{Mission::find($request->mission_id)->update(['deposed_at' => null]);}
                Log::notice("Update de la mission ".$request->mission_id);
            } catch (\Throwable $th) {
                Log::error("Mission::update: ".$th);
                return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
            }
            return redirect()->route('missions.show')->withErrors(['validate'=>'Modification de la mission avec succès']);
        } catch (\Throwable $th) {
            Log::error("Mission::update: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'mission_id' => 'required',
        ]);
        try{
            MissionLine::where('mission_id', $request->mission_id)->delete();
            Mission::find($request->mission_id)->delete();
            Log::notice("Suppression de la mission ".$request->mission_id);
            return redirect()->route('missions.show')->withErrors(['validate'=>'Suppression de la mission avec succès']);
        } catch (\Throwable $th) {
            Log::error("Mission::destroy: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }
}

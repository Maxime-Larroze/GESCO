<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLine;
use Illuminate\Http\Request;
use App\Models\Organisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

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
        $organisation = Organisation::find($request->organisation_id);
        $mission = Mission::create(
            [
                'reference' => Uuid::uuid4(),
                'organisation_id' => $request->organisation_id,
                'title' => $request->title,
                'comment' => $request->comment,
                'deposit' => 0,
            ]
        );
        return redirect()->route('missions.show');
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
        return view('auth.mission.interface', ['organisations' => Organisation::all(), 'user' => Auth::user(), 'missions' => Mission::all(), "missionLines" => MissionLine::all()]);
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
        $depot = 0;
        $missionlines = MissionLine::where("mission_id", $request->mission_id)->delete();
        if(!empty($request->title_missionline_A))
        {
            for ($i=0; $i < count($request->title_missionline_A); $i++) { 
                if(!empty($request->title_missionline_A[$i]))
                {
                    MissionLine::create([
                        'mission_id'=>$request->mission_id,
                        'title'=>$request->title_missionline_A[$i],
                        'quantity'=>$request->quantity_missionline_A[$i],
                        'price'=>$request->price_missionline_A[$i],
                        'unity'=>$request->unity_missionline_A[$i]
                    ]);
                    $depot += $request->quantity_missionline_A[$i] * $request->price_missionline_A[$i];
                }
            }
        }
        if(!empty($request->title_missionline_B))
        {
            for ($j=0; $j < count($request->title_missionline_B); $j++) { 
                if(!empty($request->title_missionline_B[array_keys($request->title_missionline_B)[$j]]))
                {
                    MissionLine::create([
                        'mission_id'=>$request->mission_id,
                        'title'=>$request->title_missionline_B[array_keys($request->title_missionline_B)[$j]],
                        'quantity'=>$request->quantity_missionline_B[array_keys($request->title_missionline_B)[$j]],
                        'price'=>$request->price_missionline_B[array_keys($request->title_missionline_B)[$j]],
                        'unity'=>$request->unity_missionline_B[array_keys($request->title_missionline_B)[$j]]
                    ]);
                    $depot += $request->price_missionline_B[array_keys($request->title_missionline_B)[$j]] * $request->quantity_missionline_B[array_keys($request->title_missionline_B)[$j]];
                }
            }
        }
        Mission::find($request->mission_id)->update([
            'title'=>$request->title,
            'deposit'=>$depot*0.45,
            'organisation_id'=>$request->organisation_id,
            'comment'=>$request->comment,
        ]);
        return redirect()->route('missions.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $mission = Mission::find($request->mission_id)->delete();
        return redirect()->route('missions.show');
    }
}

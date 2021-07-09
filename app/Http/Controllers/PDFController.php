<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLine;
use App\Models\Organisation;
use App\Models\Parametre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;

class PDFController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        try{
            $mission = Mission::find($id);
            $organisation = Organisation::find($mission->organisation_id);
            $missionLines = MissionLine::where('mission_id', $mission->id)->where('user_id', Auth::user()->id)->get();
            $parametre = Parametre::where('user_id', Auth::user()->id)->first();
            view()->share([
                'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
                'user'=>Auth::user(),
            ]);
            $pdf = PDF::loadView('auth.pdf.generate-facture')->setPaper('a4', 'landscape');
            Log::notice("Génération du PDF ".$id." pour l'utilisateur ".Auth::user()->id);
            return $pdf->download($mission->reference . '.pdf')->withErrors(['validate'=>'Génération de votre facture avec succès']);
        } catch (\Throwable $th) {
            Log::error("PDF::store: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mission = Mission::find($id);
        $organisation = Organisation::find($mission->organisation_id);
        $missionLines = MissionLine::where('mission_id', $mission->id)->where('user_id', Auth::user()->id)->get();
        $parametre = Parametre::where('user_id', Auth::user()->id)->first();
        Log::notice("Consultation de la facture ".$id." par l'utilisateur ".Auth::user()->id);
        return view('auth.pdf.generate-facture', [
            'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
            'user'=>Auth::user(),
        ]);
    }

    public function externalDownloadSigned(Request $request, $user_id, $id)
    {
        if (!$request->hasValidSignature()) {
            return redirect()->route('home');
        }
        else
        {
            $mission = Mission::find($id);
            $organisation = Organisation::find($mission->organisation_id);
            $missionLines = MissionLine::where('mission_id', $mission->id)->where('user_id', $user_id)->get();
            $parametre = Parametre::where('user_id', $user_id)->first();
            $user = User::find($user_id);
            Log::notice("Consultation externe de la facture ".$id);
            return view('auth.pdf.generate-facture', [
                'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
                'user'=>$user,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}

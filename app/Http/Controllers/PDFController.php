<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Mission;
use App\Models\MissionLine;
use App\Models\Organisation;
use App\Models\Parametre;
use App\Models\Transaction;
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
    public function factureStore($id)
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

    public function devisStore($id)
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
            $pdf = PDF::loadView('auth.pdf.generate-devis')->setPaper('a4', 'landscape');
            Log::notice("Génération du PDF ".$id." pour l'utilisateur ".Auth::user()->id);
            return $pdf->download($mission->reference . '.pdf')->withErrors(['validate'=>'Génération de votre facture avec succès']);
        } catch (\Throwable $th) {
            Log::error("PDF::store: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    public function accompteStore($id)
    {
        try{
            $mission = Mission::find($id);
            $organisation = Organisation::find($mission->organisation_id);
            $missionLines = MissionLine::where('mission_id', $mission->id)->where('user_id', Auth::user()->id)->get();
            $parametre = Parametre::where('user_id', Auth::user()->id)->first();
            $transactions = Transaction::where('user_id', Auth::user()->id)->get();
            $contributions = Contribution::where('user_id', Auth::user()->id)->get();
            view()->share([
                'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
                'user'=>Auth::user(), 'transactions'=>$transactions, 'contributions'=>$contributions
            ]);
            $pdf = PDF::loadView('auth.pdf.generate-accompte')->setPaper('a4', 'landscape');
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
    public function showFacture($id)
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

    public function showDevis($id)
    {
        $mission = Mission::find($id);
        $organisation = Organisation::find($mission->organisation_id);
        $missionLines = MissionLine::where('mission_id', $mission->id)->where('user_id', Auth::user()->id)->get();
        $parametre = Parametre::where('user_id', Auth::user()->id)->first();
        Log::notice("Consultation de la facture ".$id." par l'utilisateur ".Auth::user()->id);
        return view('auth.pdf.generate-devis', [
            'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
            'user'=>Auth::user(),
        ]);
    }

    public function showAccompte($id)
    {
        $mission = Mission::find($id);
        $organisation = Organisation::find($mission->organisation_id);
        $missionLines = MissionLine::where('mission_id', $mission->id)->where('user_id', Auth::user()->id)->get();
        $parametre = Parametre::where('user_id', Auth::user()->id)->first();
        $transactions = Transaction::where('user_id', Auth::user()->id)->get();
        $contributions = Contribution::where('user_id', Auth::user()->id)->get();
        Log::notice("Consultation de la facture ".$id." par l'utilisateur ".Auth::user()->id);
        return view('auth.pdf.generate-accompte', [
            'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
            'user'=>Auth::user(), 'transactions'=>$transactions, 'contributions'=>$contributions
        ]);
    }

    public function externalFactureSigned(Request $request, $user_id, $id)
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

    public function externalDevisSigned(Request $request, $user_id, $id)
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
            Log::notice("Consultation externe du devis ".$id);
            return view('auth.pdf.generate-devis', [
                'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
                'user'=>$user,
            ]);
        }
    }

    public function externalAccompteSigned(Request $request, $user_id, $id)
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
            $transactions = Transaction::where('user_id', $user_id)->get();
            $contributions = Contribution::where('user_id', Auth::user()->id)->get();
            Log::notice("Consultation externe d'un accompte ".$id);
            return view('auth.pdf.generate-accompte', [
                'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines, 'parametre'=>$parametre,
                'user'=>$user, 'transactions'=>$transactions, 'contributions'=>$contributions
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit()
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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendFactureEmail;
use App\Models\Mission;
use App\Models\MissionLine;
use App\Models\Parametre;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use stdClass;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendToClient(Request $request)
    {
        try{
            $this->validate($request, [
                'client_id' => 'required',
                'email' => 'mission_id',
            ]);
            $client = Organisation::find($request->client_id);
            $user = Auth::user();
            $parametre = Parametre::where('user_id', $user->id)->first();
            $facture = Mission::find($request->mission_id);
            $missionLines = MissionLine::where('mission_id', $facture->id)->where('user_id', Auth::user()->id)->get();
            view()->share([
                'mission' => $facture, 'organisation' => $client, 'missionLines' => $missionLines, 'parametre'=>$parametre,
                'user'=>Auth::user(),
            ]);
            $pdfFile = PDF::loadView('auth.pdf.generate-facture')->setPaper('a4', 'landscape');
            // $pdfFile->save('public/pdf/'.$user->id.'/'.$facture->reference.'.pdf');
            Storage::put('public/pdf/'.$user->id.'/'.$facture->reference.'.pdf', $pdfFile->output());
            $pdf=new stdClass();
            $pdf->path = 'public/pdf/'.$user->id.'/'.$facture->reference.'.pdf';
            $pdf->name = $facture->reference.'.pdf';
            Mail::to($client->email)->queue(new SendFactureEmail($client, $user, $parametre, $facture, $pdf));
            Log::info("Envoie d'une facture par email à ".$client->email." par l'utilisateur ".$user->id);
            return redirect()->route('factures.show')->withErrors(['validate'=>'La facture à bien été envoyé au destinataire']);
        } catch (\Throwable $th) {
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }
}
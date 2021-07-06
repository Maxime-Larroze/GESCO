<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Organisation;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // $societe = Organisation::all();
        // $mission = Mission::find($id);
        // $client = Client::find($mission->client_id);
        // $banque = Banque::where('societe_id', $societe->id)->first();
        // $cobanque = CoordonneeBanquaire::where('banque_id', $banque->id)->first();
        // $sbanque = SystemBanque::find($banque->system_banque_id);
        // $tvas = Tva::all();
        // $client_addresse =  Http::get('https://api-adresse.data.gouv.fr/search/?q=' . $client->ville_id . '&type=municipality&autocomplete=0')->json()['features'][0]['properties'];
        // $societe_addresse =  Http::get('https://api-adresse.data.gouv.fr/search/?q=' . $societe->ville_id . '&type=municipality&autocomplete=0')->json()['features'][0]['properties'];
        // $tacheMissions = TacheMission::where('societe_id', $societe->id)->where('mission_id', $id)->get();
        // $taches = Tache::where('societe_id', $societe->id)->get();


        // return view('pdf.generate-devis', [
        //     'mission' => $mission, 'tacheMissions' => $tacheMissions, 'taches' => $taches, 'client' => $client,
        //     'client_addresse' => $client_addresse, 'societe' => $societe, 'societe_addresse' => $societe_addresse,
        //     'tvas' => $tvas, 'banque' => $banque, 'cobanque' => $cobanque, 'sbanque' => $sbanque
        // ]);
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

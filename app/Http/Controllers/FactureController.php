<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
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
        $user = Auth::user();
        $missions = Mission::where('user_id', $user->id)->get();
        $organisations = Organisation::where('user_id', $user->id)->get();
        return view('auth.facture.interface', ['user' => $user, 'missions'=>$missions, 'organisations'=>$organisations]);


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

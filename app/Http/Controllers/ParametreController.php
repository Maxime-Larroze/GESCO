<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ParametreController extends Controller
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
        Parametre::create([
            'user_id'=>Auth::user()->id,
            'societe_name'=>Crypt::encryptString($request->societe_name),
            'siret'=>Crypt::encryptString($request->siret),
            'ape'=>Crypt::encryptString($request->ape),
            'taux_accompte'=>Crypt::encryptString($request->taux_accompte),
            'mention_a'=>Crypt::encryptString($request->mention_a),
            'mention_b'=>Crypt::encryptString($request->mention_b),
            'domiciliation'=>Crypt::encryptString($request->domiciliation),
            'rib'=>Crypt::encryptString($request->rib),
            'iban'=>Crypt::encryptString($request->iban),
            'bic'=>Crypt::encryptString($request->bic),
            'adresse'=>Crypt::encryptString($request->adresse),

        ]);
        return redirect()->route('parametres.show')->withErrors(['validate'=>'Enregistrement des paramètres avec succès']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function show(Parametre $parametre)
    {
        $parametre = Parametre::where('user_id', Auth::user()->id)->first();
        return view('auth.parametre.interface', ['user' => Auth::user(), 'parametre'=>$parametre]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function edit(Parametre $parametre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Parametre::find($request->parametre_id)->update([
            'societe_name'=>Crypt::encryptString($request->societe_name),
            'siret'=>Crypt::encryptString($request->siret),
            'ape'=>Crypt::encryptString($request->ape),
            'taux_accompte'=>Crypt::encryptString($request->taux_accompte),
            'mention_a'=>Crypt::encryptString($request->mention_a),
            'mention_b'=>Crypt::encryptString($request->mention_b),
            'domiciliation'=>Crypt::encryptString($request->domiciliation),
            'rib'=>Crypt::encryptString($request->rib),
            'iban'=>Crypt::encryptString($request->iban),
            'bic'=>Crypt::encryptString($request->bic),
            'adresse'=>Crypt::encryptString($request->adresse),
        ]);
        return redirect()->route('parametres.show')->withErrors(['validate','Enregistrement des paramètres avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parametre $parametre)
    {
        //
    }
}

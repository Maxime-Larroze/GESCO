<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

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
        $this->validate($request, [
            'societe_name' => 'required',
            'siret' => 'required',
            'ape' => 'required',
            'taux_accompte' => 'required',
            'mention_a' => 'required',
            'mention_b' => 'required',
            'domiciliation' => 'required',
            'rib' => 'required',
            'iban' => 'required',
            'bic' => 'required',
            'adresse' => 'required',
        ]);
        try{
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
            Log::notice("Création des paramètres de l'utilisateur ".Auth::user()->id);
            return redirect()->route('parametres.show')->withErrors(['validate'=>'Enregistrement des paramètres avec succès']);
        } catch (\Throwable $th) {
            Log::error("Parametre::create: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function show()
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
        $this->validate($request, [
            'societe_name' => 'required',
            'siret' => 'required',
            'ape' => 'required',
            'taux_accompte' => 'required',
            'mention_a' => 'required',
            'mention_b' => 'required',
            'domiciliation' => 'required',
            'rib' => 'required',
            'iban' => 'required',
            'bic' => 'required',
            'adresse' => 'required',
        ]);
        try{
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
            Log::notice("Update des paramètres ".$request->parametre_id." de l'utilisateur ".Auth::user()->id);
            return redirect()->route('parametres.show')->withErrors(['validate','Enregistrement des paramètres avec succès']);
        } catch (\Throwable $th) {
            Log::error("Parametre::update: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
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

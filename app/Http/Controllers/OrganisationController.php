<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'tel' => 'required',
            'address' => 'required',
            'type' => 'required',
        ]);
        try{
            Organisation::create(
                [
                    'slug' => Str::slug($request->name).'-'.rand(1,99999),
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'address' => $request->address,
                    'type' => $request->type,
                    'user_id'=>Auth::user()->id,
                ]
            );
            Log::notice("Création d'une organisation");
            return redirect()->route('organisations.show')->withErrors(['validate'=>'Enregistrement de votre client avec succès']);
        } catch (\Throwable $th) {
            Log::error("Organisation::create: ".$th);
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
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        return view('auth.organisation.interface', ['organisations' => Organisation::where('user_id', Auth::user()->id)->get(), 'user' => Auth::user(), 'parametre'=> Parametre::where('user_id', Auth::user()->id)->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Organisation $organisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'tel' => 'required',
            'address' => 'required',
            'type' => 'required',
        ]);
        try{
            Organisation::find($request->organisation_id)->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'address' => $request->address,
                    'type' => $request->type,
                ]
            );
            Log::notice("Update de l'organisation ".$request->organisation_id);
            return redirect()->route('organisations.show')->withErrors(['validate'=>'Modification du client avec succès']);
        } catch (\Throwable $th) {
            Log::error("Organisation::update: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'organisation_id' => 'required',
        ]);
        try{
            Organisation::find($request->organisation_id)->delete();
            Log::notice("Delete de l'organisation ".$request->organisation_id);
            return redirect()->route('organisations.show')->withErrors(['validate'=>'Suppression de votre client avec succès']);
        } catch (\Throwable $th) {
            Log::error("Organisation::destroy: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }
}

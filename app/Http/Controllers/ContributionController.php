<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Organisation;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContributionController extends Controller
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
        $this->validate($request, [
            'price' => 'required',
            'title' => 'required',
            'organisation_id' => 'required',
        ]);
        try{
            if(!empty($request->comment))
            {
                Contribution::create([
                    'price'=>$request->price,
                    'title'=>$request->title,
                    'user_id'=>Auth::user()->id,
                    'organisation_id'=>$request->organisation_id,
                    'comment'=>$request->comment,
                ]);
            }
            else
            {
                Contribution::create([
                    'price'=>$request->price,
                    'title'=>$request->title,
                    'user_id'=>Auth::user()->id,
                    'organisation_id'=>$request->organisation_id,
                ]);
            }
            Log::notice("Création d'une nouvelle contribution par ".Auth::user()->id." sur ".$request->organisation_id);
            return redirect()->route('contributions.show')->withErrors(['validate'=>'Contribution enregistrée avec succès']);
        } catch (\Throwable $th) {
            Log::error("Contribution::create: ".$th);
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $parametre = Parametre::where('user_id', $user->id)->first();
        $contributions = Contribution::where('user_id', $user->id)->get();
        $organisations = Organisation::where('user_id', $user->id)->get();
        return view('auth.contribution.interface', ['user'=>$user, 'contributions'=>$contributions, 
        'parametre'=>$parametre, 'organisations'=>$organisations]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function edit(Contribution $contribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'price' => 'required',
            'title' => 'required',
            'organisation_id' => 'required',
        ]);
        try{
            if(!empty($request->comment))
            {
                Contribution::find($request->contribution_id)->update([
                    'price'=>$request->price,
                    'title'=>$request->title,
                    'organisation_id'=>$request->organisation_id,
                    'comment'=>$request->comment,
                ]);
            }
            else
            {
                Contribution::find($request->contribution_id)->update([
                    'price'=>$request->price,
                    'title'=>$request->title,
                    'organisation_id'=>$request->organisation_id,
                    'comment'=>null,
                ]);
            }
            Log::notice("Update de la contribution ".$request->contribution_id." par ".Auth::user()->id);
            return redirect()->route('contributions.show')->withErrors(['validate'=>'Contribution modifiée avec succès']);
        } catch (\Throwable $th) {
            Log::error("Contribution::update: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $this->validate($request, [
                'contribution_id' => 'required',
            ]);
            Log::notice("Delete de la contribution ".$request->contribution_id);
            Contribution::find($request->contribution_id)->delete();
            return redirect()->route('contributions.show')->withErrors(['validate'=>'Contribution supprimée avec succès']);
        } catch (\Throwable $th) {
            Log::error("Contribution::delete: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Mission;
use App\Models\Organisation;
use App\Models\Parametre;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccompteController extends Controller
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
        $missions = Mission::where('user_id', $user->id)->where('signed_at','!=',null)->where('deposed_at','!=',null)->get();
        $organisations = Organisation::where('user_id', $user->id)->get();
        $parametre = Parametre::where('user_id', $user->id)->first();
        $contributions = Contribution::where('user_id', $user->id)->get();
        $transactions = Transaction::where('user_id', $user->id)->get();
        return view('auth.facture-accompte.interface', ['user' => $user, 'missions'=>$missions, 'organisations'=>$organisations,
            'parametre'=>$parametre, 'contributions'=>$contributions, 'transactions'=>$transactions]);
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

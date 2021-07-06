<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLine;
use App\Models\Organisation;
use Illuminate\Http\Request;
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
        $mission = Mission::find($id);
        $organisation = Organisation::find($mission->organisation_id);
        $missionLines = MissionLine::where('mission_id', $mission->id)->get();

        view()->share([
            'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines,
        ]);

        $pdf = PDF::loadView('auth.pdf.generate-facture')->setPaper('a4', 'landscape');
        return $pdf->download($mission->reference . '.pdf');
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
        $missionLines = MissionLine::where('mission_id', $mission->id)->get();
        return view('auth.pdf.generate-facture', [
            'mission' => $mission, 'organisation' => $organisation, 'missionLines' => $missionLines,
        ]);
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

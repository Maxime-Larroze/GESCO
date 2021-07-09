<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Mission;
use App\Models\Organisation;
use App\Models\Parametre;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
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
            'source_type' => 'required',
            'source_id' => 'required',
            'price' => 'required',
        ]);
        try{
            if(!empty($request->payed_at))
            {
                Transaction::create([
                    'source_type'=>$request->source_type,
                    'source_id'=>$request->source_id,
                    'user_id'=>Auth::user()->id,
                    'price'=>$request->price,
                    'payed_at'=>$request->payed_at,
                ]);
            }
            else
            {
                Transaction::create([
                    'source_type'=>$request->source_type,
                    'source_id'=>$request->source_id,
                    'user_id'=>Auth::user()->id,
                    'price'=>$request->price,
                ]);
            }
            Log::notice("Création d'une nouvelle transaction par ".Auth::user()->id);
            return redirect()->route('transactions.show')->withErrors(['validate'=>'Transaction enregistrée avec succès']);
        } catch (\Throwable $th) {
            Log::error("Transaction::create: ".$th);
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
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $parametre = Parametre::where('user_id', $user->id)->first();
        $transactions = Transaction::where('user_id', $user->id)->get();
        $missions = Mission::where('user_id', $user->id)->get();
        $contributions = Contribution::where('user_id', $user->id)->get();
        $organisations = Organisation::where('user_id', $user->id)->get();
        return view('auth.transaction.interface', ['user'=>$user, 'transactions'=>$transactions, 'missions'=>$missions, 
        'contributions'=>$contributions, 'parametre'=>$parametre, 'organisations'=>$organisations]);
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
        $this->validate($request, [
            'source_type' => 'required',
            'source_id' => 'required',
            'price' => 'required',
            'transaction_id' => 'required',
        ]);
        try{
            if(!empty($request->payed_at) && isset($request->payed_at))
            {
                Transaction::find($request->transaction_id)->update([
                    'source_type'=>$request->source_type,
                    'source_id'=>$request->source_id,
                    'price'=>$request->price,
                    'payed_at'=>$request->payed_at,
                ]);
            }
            else
            {
                Transaction::find($request->transaction_id)->update([
                    'source_type'=>$request->source_type,
                    'source_id'=>$request->source_id,
                    'price'=>$request->price,
                    'payed_at'=>null,
                ]);
            }
            Log::notice("Modification de la transaction ".$request->transaction_id);
            return redirect()->route('transactions.show')->withErrors(['validate'=>'Transaction enregistrée avec succès']);
        } catch (\Throwable $th) {
            Log::error("Transaction::update: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $this->validate($request, [
                'transaction_id' => 'required',
            ]);
            Log::notice("Delete de la transaction ".$request->transaction_id);
            Transaction::find($request->transaction_id)->delete();
            return redirect()->route('transactions.show')->withErrors(['validate'=>'Transaction supprimée avec succès']);
        } catch (\Throwable $th) {
            Log::error("Transaction::destroy: ".$th);
            return back()->withErrors(['error'=>"une erreur est survenue pendant l'opération: ".$th]);
        }
    }
}

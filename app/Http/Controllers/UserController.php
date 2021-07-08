<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfil()
    {
        $user = Auth::user();
        $parametre = Parametre::where('user_id',$user->id)->first();
        return view('auth.profil.interface', ['user' => $user, 'parametre'=>$parametre]);
    }
}

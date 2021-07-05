<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfil()
    {
        $user = Auth::user();
        return view('auth.profil.interface', ['user' => $user]);
    }
}

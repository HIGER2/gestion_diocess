<?php

namespace App\Http\Controllers;

use App\Models\Pretre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{

    public function findprete($id)
    {
        $prete = Pretre::with(['diocese', 'diplome_academique', 'lieuAffectation', 'parcourt', 'diplome_ecclesiastique'])->find($id);
        return view('prete-detail', ['prete' => $prete]);
    }

    public function userAuth()
    {
        $user = Auth::user();
        return view('user', ['user' => $user]);
    }
}

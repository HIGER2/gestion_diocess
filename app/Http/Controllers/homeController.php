<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pretre;
use App\Models\Diocese;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Object_;

class homeController extends Controller
{

    public function analytic()
    {

        $user = Auth::user();

        // Compteurs globaux
        $diocese_count = Diocese::count();
        $dioceses = Diocese::orderBy('created_at', 'desc')->get();
        $prete_count = Pretre::where('status', 'active')->count();
        $prete_count_inactive = Pretre::where('status', 'inactive')->count();
        $preteRetraite = Pretre::whereRaw('(YEAR(CURDATE()) - YEAR(date_naissance)) = 55')->count();
        // Récupération des prêtres inactifs
        $prete_inactive_query = Pretre::with('diocese')
            ->with("diplome_academique")
            ->with("diplome_ecclesiastique")
            ->with("lieuAffectation")
            ->where('status', 'inactive');

        // Filtrage spécifique pour les admins
        if ($user->role === 'admin') {
            $prete_inactive_query->where('dioceses_id', $user->diocese_id); // Correction de `$user->diocese` en `$user->diocese_id`
        }

        // Récupération des données des prêtres inactifs après filtrage
        $prete_inactive = $prete_inactive_query->orderBy('created_at', 'desc')->get();

        // Compteur des utilisateurs
        $user_count = User::count();

        // Retour de la réponse JSON
        return response()->json([
            'message' => 'analytic',
            'data' => (object)[
                "user_count" => $user_count,
                "prete_count_retraite" => $preteRetraite,
                "prete_count" => $prete_count,
                "diocese_count" => $diocese_count, // Correction de la clé pour correspondre au nom
                "prete_count_inactive" => $prete_count_inactive,
                "prete_inactive" => $prete_inactive,
                "dioceses" => $dioceses, // Correction de la clé pour cohérence avec le pluriel
            ],
        ], 201);
    }
}

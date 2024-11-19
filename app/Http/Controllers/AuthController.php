<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Connexion d'un utilisateur.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            return response()->json([
                'message' => 'Connexion réussie.',
                'redirect' => '/diocese-manager'  // URL vers laquelle le client doit rediriger
            ], 200);
        }

        return response()->json([
            'message' => 'Identifiants incorrects.',
        ], 401);
    }

    /**
     * Déconnexion de l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ], 200);
    }

    /**
     * Récupérer l'utilisateur connecté.
     */
    public function me()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Aucun utilisateur connecté.',
            ], 401);
        }

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
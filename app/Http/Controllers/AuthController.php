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
    // Valider les données d'entrée
    public function login(Request $request)
    {
        // Valider les données d'entrée
        $credentials = $request->validate([
            'login' => 'required|string', // Peut être email, téléphone ou nom d'utilisateur
            'password' => 'required|string|min:6',
        ]);

        // Vérifier si l'utilisateur existe via email, téléphone ou nom d'utilisateur
        $user = User::where('email', $credentials['login'])
            ->orWhere('phone', $credentials['login'])
            ->first();

        // Si aucun utilisateur trouvé ou mot de passe incorrect
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Identifiants incorrects.',
            ], 401);
        }

        // Authentifier l'utilisateur
        Auth::login($user);
        $request->session()->regenerate();
        $path = "/";

        // if ($user->role == 'admin') {
        //     $path = "/diocese-manager/" . $user->diocese_id;
        // }

        // Réponse en cas de succès
        return response()->json([
            'message' => 'Connexion réussie.',
            'redirect' => $path, // URL vers laquelle le client doit rediriger
        ], 200);
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
            'redirect' => '/auth/login',
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
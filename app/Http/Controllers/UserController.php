<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255', // Le nom est obligatoire
            'prenoms' => 'required|string|max:255', // Le prénom est obligatoire
            'role' => 'required|string|in:super_admin,admin,user', // Vérifie que le rôle est valide
            'phone' => 'required|string|max:15|unique:users,phone', // Vérifie que le téléphone est unique
            // 'email' => 'required|email|max:255|unique:users,email', // Vérifie que l'email est unique
            'password' => 'required|string|min:8', // Le mot de passe doit avoir au moins 8 caractères
            // 'diocese_id' => 'nullable|integer|exists:dioceses,id', // Vérifie que le diocèse existe (optionnel)
        ]);

        if ($validator->fails()) {
            // Retourner les erreurs de validation si elles existent
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Étape 2 : Créer l'utilisateur
        try {
            $user = User::create([
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'role' => $request->role,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'diocese_id' => $request->diocese_id,
            ]);



            return response()->json([
                'message' => 'Utilisateur créé avec succès.',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            // Retourner une erreur en cas de problème inattendu

            return response()->json([
                'error' => 'Une erreur est survenue lors de la création de l\'utilisateur.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Récupérer les détails d'un prêtre.
     */
    public function show($id)
    {
        $user = User::with('diocese')->find($id);

        if (!$user) {
            return response()->json(['message' => 'Prêtre introuvable.'], 404);
        }

        return response()->json($user);
    }

    /**
     * Modifier un prêtre existant.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Prêtre introuvable.'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenoms' => 'sometimes|string|max:255',
            'matricule' => "sometimes|string|max:255|unique:pretres,matricule,$id",
            'dioceses_id' => 'nullable|exists:dioceses,id',
            'date_naissance' => 'sometimes|date',
            'lieu_naissance' => 'sometimes|string|max:255',
            'date_ordination_sacerdotale' => 'sometimes|date',
            'lieu_ordination_sacerdotale' => 'sometimes|string|max:255',
            'diplome_etude_ecclesiastique' => 'nullable|string|max:300',
            'diplome_etude_profane' => 'nullable|string|max:300',
            'numero_telephone' => 'nullable|numeric',
            'adresse_electronique' => "sometimes|string|email|max:255|unique:pretres,adresse_electronique,$id",
        ]);

        $pretre->update($validated);

        return response()->json([
            'message' => 'Prêtre mis à jour avec succès.',
            'pretre' => $pretre,
        ]);
    }

    public function listUser()
    {
        $user = User::get();
        return response()->json([
            'user' => $user,
        ]);
    }
    /**
     * Supprimer un prêtre.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'user introuvable.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'user supprimé avec succès.']);
    }
}
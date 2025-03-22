<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //

    public function store(Request $request)
    {

        $rules = [
            'nom' => 'required|string|max:255', // Le nom est obligatoire
            'prenoms' => 'required|string|max:255', // Le prénom est obligatoire
            'role' => 'required|string|in:super_admin,admin,user', // Vérifie que le rôle est valide
            'phone' => 'required|string|max:15',
        ];

        if (!$request->id) {
            $rules["phone"] = "required|string|max:15|unique:users,phone";
            $rules['email'] = 'required|string|email|max:255|unique:users,email';
            $rules['password'] =  [
                "required",
                "string",
                "min:8",
                "regex:/[A-Z]/",
                "regex:/[a-z]/",
                "regex:/[0-9]/",
                "regex:/[@$!%*?&]/",
                // "confirmed",
            ];
        } else if ($request->id && !$request->password) {
            $user = User::findOrFail($request->id);
            $rules["phone"] = [
                "required",
                "string",
                "max:15",
                Rule::unique('users', 'phone')->ignore($user->id), // Ignore l'ancien numéro
            ];;
            $rules['email'] = [
                "nullable",
                "string",
                "email",
                "max:255",
                Rule::unique('users', 'email')->ignore($user->id),
            ];
        } else if ($request->id && $request->password && $request->old_password) {
            $user = User::findOrFail($request->id);
            $rules["phone"] = [
                "required",
                "string",
                "max:15",
                Rule::unique('users', 'phone')->ignore($user->id), // Ignore l'ancien numéro
            ];;
            $rules['email'] = [
                "nullable",
                "string",
                "email",
                "max:255",
                Rule::unique('users', 'email')->ignore($user->id),
            ];
            $rules['password'] =  [
                "required",
                "string",
                "min:8",
                "regex:/[A-Z]/",
                "regex:/[a-z]/",
                "regex:/[0-9]/",
                "regex:/[@$!%*?&]/",
                // "confirmed",
            ];
            $rules['old_password'] =  [
                "required",
                "string",
                "min:8",
                "regex:/[A-Z]/",
                "regex:/[a-z]/",
                "regex:/[0-9]/",
                "regex:/[@$!%*?&]/",
                // "confirmed",
            ];
        }

        $messages = [
            'nom.required' => 'Le champ "Nom" est obligatoire.',
            'nom.string' => 'Le champ "Nom" doit être une chaîne de caractères.',
            'nom.max' => 'Le champ "Nom" ne doit pas dépasser 255 caractères.',
            'prenoms.required' => 'Le champ "Prénoms" est obligatoire.',
            'prenoms.string' => 'Le champ "Prénoms" doit être une chaîne de caractères.',
            'prenoms.max' => 'Le champ "Prénoms" ne doit pas dépasser 255 caractères.',
            'role.required' => 'Le champ "Rôle" est obligatoire.',
            'role.string' => 'Le champ "Rôle" doit être une chaîne de caractères.',
            'role.in' => 'Le champ "Rôle" doit être l’une des valeurs suivantes : super_admin, admin, user.',
            'phone.required' => 'Le champ "Téléphone" est obligatoire.',
            'phone.string' => 'Le champ "Téléphone" doit être une chaîne de caractères.',
            'phone.max' => 'Le champ "Téléphone" ne doit pas dépasser 15 caractères.',
            'phone.unique' => 'Le numéro de téléphone est déjà utilisé.',
            'email.unique' => 'L\'email est déjà utilisé.',
            'password.required' => 'Le champ "Mot de passe" est obligatoire.',
            'password.string' => 'Le champ "Mot de passe" doit être une chaîne de caractères.',
            'password.min' => 'Le champ "Mot de passe" doit contenir au moins 8 caractères.',
            'password.regex' => 'Le champ "Mot de passe" doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&).',
            'old_password.required' => 'Le champ "Ancien mot de passe" est obligatoire.',
            'old_password.string' => 'Le champ "Ancien mot de passe" doit être une chaîne de caractères.',
            'old_password.min' => 'Le champ "Ancien mot de passe" doit contenir au moins 8 caractères.',
            'old_password.regex' => 'Le champ "Ancien mot de passe" doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&).',
            // 'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ];

        $validator = $request->validate($rules, $messages);
        // Étape 2 : Créer l'utilisateur

        try {

            $authUser = Auth::user();

            if ($request->id) {
                $user = User::where('id', $request->id)->first();

                if ($authUser->role == $user->role &&  $authUser->id == $user->id) {
                    if (!Hash::check($request->old_password, $user->password)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'L\'ancien mot de passe est incorrect.',
                        ], 400);
                    }
                }
                $data = [
                    'nom' => $request->nom,
                    'prenoms' => $request->prenoms,
                    'role' => $request->role,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'diocese_id' => $request->diocese_id,
                ];

                if ($request->password) {
                    $data['password'] = Hash::make($request->password);
                }



                $user->update($data);
            } else {
                $user = User::create([
                    'nom' => $request->nom,
                    'prenoms' => $request->prenoms,
                    'role' => $request->role,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'diocese_id' => $request->diocese_id,
                ]);
            }




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
            return response()->json(['message' => 'utilisateur introuvable.'], 404);
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
        $user = User::loadForDiocese()->with('diocese')->get();
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

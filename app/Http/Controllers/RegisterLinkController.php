<?php

namespace App\Http\Controllers;

use App\Models\Diocese;
use App\Models\RegsiterLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterLinkController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            // 'dioceses_id' => 'required|exists:dioceses,id',
            // 'username' => 'required|string',
            'password' => 'nullable|string|min:8'
        ];


        if (!$request->id) {
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
        } else if ($request->id && $request->password) {
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
        }

        $messages = [
            'dioceses_id.required' => 'Le champ diocèse est obligatoire.',
            'dioceses_id.exists' => 'Le diocèse sélectionné est invalide.',
            'username.required' => 'Le nom d’utilisateur est obligatoire.',
            'username.string' => 'Le nom d’utilisateur doit être une chaîne de caractères.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.regex' => 'Le champ "Mot de passe" doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&).'
        ];

        $request->validate($rules, $messages);

        if ($request->id) {
            $link = RegsiterLink::findOrFail($request->id);

            $data = [
                'status' => $request->status,
                'username' => $request->username,
                'dioceses_id' => $request->dioceses_id,
                'expires_at' => $request->expires_at ?? $link->expires_at,
            ];

            if ($request->password) {
                $data['password'] =  Hash::make($request->password);
            }

            $link->update($data);

            return response()->json(['message' => 'Lien modifié', 'link' => $link], 201);
        } else {
            $token = bin2hex(random_bytes(16));

            $link = RegsiterLink::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'token' => $token,
                'link' => env('APP_URL') . '/register-links/access/' . $token,
                'dioceses_id' => $request->dioceses_id,
                // 'expires_at' => now()->addDays(7),
            ]);

            return response()->json(['message' => 'Lien creé avec succès', 'link' => $link], 201);
        }
    }

    /**
     * Mettre à jour un lien existant.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'sometimes|required|string|unique:diocese_links,username,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'expires_at' => 'nullable|date',
        ]);

        $link = RegsiterLink::findOrFail($id);

        $link->update([
            'username' => $request->username ?? $link->username,
            'password' => $request->password ? Hash::make($request->password) : $link->password,
            'expires_at' => $request->expires_at ?? $link->expires_at,
        ]);

        return response()->json(['message' => 'Link updated successfully', 'link' => $link], 200);
    }

    public function access($token)
    {
        $link = RegsiterLink::where('token', $token)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->first();

        if (!$link) {
            abort(403, 'This link is invalid or has expired.');
        }
        $diocese = Diocese::findOrFail($link->dioceses_id);

        return view('inscription', ['token' => $token, 'diocese' => $diocese]);
    }


    public function all()
    {
        $user = Auth::user();

        $query = RegsiterLink::loadForDiocese()->with('diocese');

        return response()->json([
            'data' => $query->orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Supprimer un lien.
     */
    public function delete($id)
    {
        $link = RegsiterLink::findOrFail($id);
        $link->delete();

        return response()->json(['message' => 'Link deleted successfully'], 200);
    }

    /**
     * Authentifier un utilisateur via un lien sécurisé.
     */
    public function authenticate(Request $request, $token)
    {
        $link = RegsiterLink::where('token', $token)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->first();

        if (!$link) {
            return response()->json(['message' => 'Invalid or expired link'], 403);
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Le champ "username" est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        if (strtolower($link->username) !== strtolower($request->username) || !Hash::check($request->password, $link->password)) {
            return response()->json(['message' => 'Identifiant de connexion invalide', 'data' => $link], 403);
        }

        // Authentifier via le guard personnalisé
        Auth::guard('register_link')->login($link);

        return response()->json([
            'message' => 'Connexion réussie.',
            'redirect' => "/register-links/access/" . $token, // URL vers laquelle le client doit rediriger
        ], 200);
    }
}

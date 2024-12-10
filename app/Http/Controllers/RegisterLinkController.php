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
        $request->validate([
            'dioceses_id' => 'required|exists:dioceses,id',
            'username' => 'required|string|unique:regsiter_links,username',
            'password' => 'required|string|min:8',
        ]);

        $token = bin2hex(random_bytes(16));

        $link = RegsiterLink::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'token' => $token,
            'link' => env('APP_URL') . '/register-links/access/' . $token,
            'dioceses_id' => $request->dioceses_id,
            'expires_at' => now()->addDays(7),
        ]);

        return response()->json(['message' => 'Link created successfully', 'link' => $link], 201);
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

        $query = RegsiterLink::with('diocese');

        if ($user->role === 'admin') {
            $query->where('dioceses_id', $user->diocese_id); // Correction de `$user->diocese` en `$user->diocese_id`
        }

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

        if ($link->username !== $request->username || !Hash::check($request->password, $link->password)) {
            return response()->json(['message' => 'Identifiant de connexion invalide'], 403);
        }

        // Authentifier via le guard personnalisé
        Auth::guard('register_link')->login($link);

        return response()->json([
            'message' => 'Connexion réussie.',
            'redirect' => "/register-links/access/" . $token, // URL vers laquelle le client doit rediriger
        ], 200);
    }
}

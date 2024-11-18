<?php

namespace App\Http\Controllers;

use App\Models\Diocese;
use App\Models\Pretre;
use Illuminate\Http\Request;

class DioceseController extends Controller
{
    /**
     * Crée un nouveau diocèse.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'diocese' => 'required|string|max:255',
            'abreviation' => 'required|string|max:10|unique:dioceses,abreviation',
        ]);

        $diocese = Diocese::create($validated);

        return response()->json([
            'message' => 'Diocèse créé avec succès.',
            'diocese' => $diocese,
        ], 201);
    }

    /**
     * Modifie un diocèse existant.
     */
    public function update(Request $request, $id)
    {
        $diocese = Diocese::findOrFail($id);

        $validated = $request->validate([
            'diocese' => 'sometimes|required|string|max:255',
            'abreviation' => "sometimes|required|string|max:10|unique:dioceses,abreviation,{$diocese->id}",
        ]);

        $diocese->update($validated);

        return response()->json([
            'message' => 'Diocèse mis à jour avec succès.',
            'diocese' => $diocese,
        ]);
    }

    /**
     * Supprime un diocèse.
     */
    public function destroy($id)
    {
        $diocese = Diocese::findOrFail($id);

        $diocese->delete();

        return response()->json([
            'message' => 'Diocèse supprimé avec succès.',
        ]);
    }

    /**
     * Affiche les détails d'un diocèse.
     */
    public function show($id)
    {
        $diocese = Diocese::with('pretres')->findOrFail($id);

        return response()->json([
            'diocese' => $diocese,
        ]);
    }

    /**
     * Liste les prêtres associés à un diocèse.
     */
    public function listPretres($id)
    {
        $diocese = Diocese::findOrFail($id);

        $pretres = $diocese->pretres;

        return response()->json([
            'diocese' => $diocese->diocese,
            'pretres' => $pretres,
        ]);
    }
}

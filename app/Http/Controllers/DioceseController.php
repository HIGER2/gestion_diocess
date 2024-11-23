<?php

namespace App\Http\Controllers;

use App\Models\Diocese;
use App\Models\Pretre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'emplacement' => 'required|string|max:255',
            // 'file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

        ]);

        // Enregistrement du fichier s'il existe

        $filePath = "";
        if ($request->hasFile('file')) {
            // Récupération de l'extension et génération d'un nom unique pour le fichier
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = uniqid() . '_' . time() . '.' . $extension;

            // Stockage du fichier dans le répertoire 'uploads/dioceses' du disque public
            $filePath = $request->file('file')->storeAs('uploads/dioceses', $fileName, 'public');
        }

        // Traitement des autres données
        $diocese = Diocese::create([
            'diocese' => $request->diocese,
            'abreviation' => $request->abreviation,
            'emplacement' => $request->emplacement,
            'url_image' => $filePath ? Storage::url($filePath) : null,  // Si un fichier a été téléchargé, on enregistre son URL, sinon null
        ]);

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


    public function listDiocese()
    {
        $diocese = Diocese::orderBy('created_at', 'desc')->get(); // Récupère tous les enregistrements avec leurs champs
        return response()->json([
            'data' => $diocese,
        ]);
    }
}
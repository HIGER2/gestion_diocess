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
        // Validation des champs
        $validated = $request->validate([
            'diocese' => 'required|string|max:255',
            'abreviation' => 'required|string|max:10|unique:dioceses,abreviation',
            'emplacement' => 'required|string|max:255',
            'url_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Gestion du fichier image
        $images = null; // Défaut si aucune image n'est fournie
        if ($request->hasFile('url_image')) {
            // Récupérer le fichier téléchargé
            $imageFile = $request->file('url_image');

            // Générer un nom unique pour le fichier
            $imageName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();

            // Déplacer l'image dans le dossier 'public/images'
            $imageFile->move(public_path('images'), $imageName);

            // Chemin relatif vers le fichier
            $images = 'images/' . $imageName;
        }

        // Enregistrer les données dans la base
        $diocese = Diocese::create([
            'diocese' => $validated['diocese'],
            'abreviation' => $validated['abreviation'],
            'emplacement' => $validated['emplacement'],
            'url_image' => $images, // Ajout de l'image si disponible
        ]);

        // Retourner une réponse JSON
        return response()->json([
            'message' => 'Diocèse enregistré avec succès',
            'diocese' => $diocese
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
        $diocese = Diocese::get(); // Récupère tous les enregistrements avec leurs champs
        return response()->json([
            'data' => $diocese,
        ]);
    }
}
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
        $rules =  [
            'diocese' => 'required|string|max:255',
            'emplacement' => 'required|string|max:255',
        ];

        if (!$request->id) {
            $rules['abreviation'] = 'required|string|max:10|unique:dioceses,abreviation';
        }

        $validated = $request->validate($rules);

        // Enregistrement du fichier s'il existe

        $filePath = "";
        if ($request->hasFile('file')) {
            // Récupération de l'extension et génération d'un nom unique pour le fichier
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = uniqid() . '_' . time() . '.' . $extension;

            // Stockage du fichier dans le répertoire 'uploads/dioceses' du disque public
            $filePath = $request->file('file')->storeAs('uploads/dioceses', $fileName, 'public');
        }

        $diocese  = "";
        // Traitement des autres données
        if ($request->id) {

            $value = [
                'diocese' => $request->diocese,
                'emplacement' => $request->emplacement,
            ];
            if ($filePath) {
                $value['url_image'] = $filePath;
            }

            $diocese = Diocese::where('id', $request->id)->update($value);
        } else {
            $diocese = Diocese::create([
                'diocese' => $request->diocese,
                'abreviation' => $request->abreviation,
                'emplacement' => $request->emplacement,
                'url_image' => $filePath ? Storage::url($filePath) : null,  // Si un fichier a été téléchargé, on enregistre son URL, sinon null
            ]);
        }


        return response()->json([
            'message' => $request->id ? 'Diocèse mise à jour avec succès.' : 'Diocèse créé avec succès.',
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
        $diocese = Diocese::with(['pretres' => function ($q) {
            $q->with(['diocese', 'diplome_academique', 'diplome_ecclesiastique', 'lieuAffectation'])
                ->where('status', 'active')
                ->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return response()->json([
            'diocese' => $diocese,
            'count_pretes' => $diocese->pretres->count()
        ]);
    }

    /**
     * Liste les prêtres associés à un diocèse.
     */


    public function listDiocese(Request $request)
    {
        $query = Diocese::orderBy('created_at', 'desc');

        // Recherche par nom ou d'autres champs
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nom', 'like', '%' . $search . '%');
        }

        $count =  $query->count();
        // Pagination
        $dioceses = $query->paginate(25);
        return response()->json([
            'data' => $dioceses,
        ]);
    }


    public function listAll(Request $request)
    {
        $dioceses = Diocese::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $dioceses,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Diocese;
use App\Models\Pretre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PretreController extends Controller
{
    /**
     * Créer un nouveau prêtre.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'matricule' => 'required|string|max:255|unique:pretres',
            'dioceses_id' => 'nullable|exists:dioceses,id',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'date_ordination_sacerdotale' => 'required|date',
            'lieu_ordination_sacerdotale' => 'required|string|max:255',
            'diplome_etude_ecclesiastique' => 'nullable|string|max:300',
            'diplome_etude_profane' => 'nullable|string|max:300',
            'numero_telephone' => 'nullable|numeric',
            'adresse_electronique' => 'required|string|email|max:255|unique:pretres',
        ]);

        $diocese = Diocese::findOrFail($validated['dioceses_id']);
        $abbreviation = $diocese->abreviation;

        // Générer le matricule
        $validated['matricule'] = $this->generateMatricule(
            $abbreviation,
            $validated['nom'],
            $validated['prenoms']
        );
        $pretre = Pretre::create($validated);

        return response()->json([
            'message' => 'Prêtre créé avec succès.',
            'pretre' => $pretre,
        ], 201);
    }

    /**
     * Récupérer les détails d'un prêtre.
     */
    public function show($id)
    {
        $pretre = Pretre::find($id);

        if (!$pretre) {
            return response()->json(['message' => 'Prêtre introuvable.'], 404);
        }

        return response()->json($pretre);
    }

    /**
     * Modifier un prêtre existant.
     */
    public function update(Request $request, $id)
    {
        $pretre = Pretre::find($id);

        if (!$pretre) {
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

    /**
     * Supprimer un prêtre.
     */
    public function destroy($id)
    {
        $pretre = Pretre::find($id);

        if (!$pretre) {
            return response()->json(['message' => 'Prêtre introuvable.'], 404);
        }

        $pretre->delete();

        return response()->json(['message' => 'Prêtre supprimé avec succès.']);
    }

    private function generateMatricule($abbreviation, $nom, $prenoms)
    {
        $firstLetterNom = strtoupper(Str::substr($nom, 0, 1));
        $firstLetterPrenom = strtoupper(Str::substr($prenoms, 0, 1));
        $randomNumber = random_int(10000, 99999);
        return "{$abbreviation}-{$firstLetterNom}{$firstLetterPrenom}-{$randomNumber}";
    }

    public function listPretres()
    {
        $pretres = Pretre::with('diocese')->get();

        return response()->json([
            'pretres' => $pretres,
        ]);
    }

    public function pretres($id)
    {
        // Récupère le diocèse avec son ID
        $diocese = Diocese::findOrFail($id);

        // Récupère les prêtres associés à ce diocèse
        $pretres = Pretre::where('dioceses_id', $id)->with('diocese')->get();

        return response()->json([
            'diocese' => $diocese,
            'pretres' => $pretres,
        ]);
    }
}
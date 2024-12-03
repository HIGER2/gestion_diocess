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
        $rules = [
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'dioceses_id' => 'nullable|exists:dioceses,id',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'date_ordination_sacerdotale' => 'required|date',
            'lieu_ordination_sacerdotale' => 'required|string|max:255',
            'diplome_etude_ecclesiastique' => 'nullable|string|max:300',
            'diplome_etude_profane' => 'nullable|string|max:300',
            'numero_telephone' => 'nullable|numeric',
            'adresse_electronique' => 'nullable|string|email|max:255',
        ];

        // Si c'est une création (pas d'ID), ajouter la validation unique
        if (!$request->id) {
            $rules['numero_telephone'] = 'nullable|numeric|unique:pretres,numero_telephone';
            $rules['adresse_electronique'] = 'nullable|string|email|max:255|unique:pretres,adresse_electronique';
        }

        $validated = $request->validate($rules, [
            'nom.required' => 'Le champ "Nom" est obligatoire.',
            'prenoms.required' => 'Le champ "Prénoms" est obligatoire.',
            'date_naissance.required' => 'Le champ "Date de naissance" est obligatoire.',
            'date_naissance.date' => 'Le champ "Date de naissance" doit être une date valide.',
            'lieu_naissance.required' => 'Le champ "Lieu de naissance" est obligatoire.',
            'lieu_naissance.string' => 'Le champ "Lieu de naissance" doit être une chaîne de caractères.',
            'date_ordination_sacerdotale.required' => 'Le champ "Date d’ordination sacerdotale" est obligatoire.',
            'date_ordination_sacerdotale.date' => 'Le champ "Date d’ordination sacerdotale" doit être une date valide.',
            'lieu_ordination_sacerdotale.required' => 'Le champ "Lieu d’ordination sacerdotale" est obligatoire.',
            'lieu_ordination_sacerdotale.string' => 'Le champ "Lieu d’ordination sacerdotale" doit être une chaîne de caractères.',
            'diplome_etude_ecclesiastique.string' => 'Le champ "Diplôme d’étude ecclésiastique" doit être une chaîne de caractères.',
            'diplome_etude_profane.string' => 'Le champ "Diplôme d’étude profane" doit être une chaîne de caractères.',
            'numero_telephone.numeric' => 'Le champ "Numéro de téléphone" doit être un nombre.',
            'numero_telephone.unique' => 'Le numéro de téléphone est déjà utilisé.',
            'adresse_electronique.email' => 'Le champ "Adresse électronique" doit être une adresse email valide.',
            'adresse_electronique.unique' => 'L’adresse électronique saisie est déjà utilisée.',
        ]);

        $diocese = Diocese::findOrFail($request['dioceses_id']);
        $abbreviation = $diocese->abreviation;

        // Générer le matricule
        $request['matricule'] = $this->generateMatricule(
            $abbreviation,
            $validated['nom'],
            $validated['prenoms']
        );

        if ($request->id) {
            // Mise à jour
            $data = $request->except('diocess');

            // Update the record using the filtered data
            $pretre = Pretre::where('id', $request->id)->update($data);
        } else {
            // Création
            $pretre = Pretre::create($request->all());
        }

        return response()->json([
            'message' => $request->id ? 'Prêtre mis à jour avec succès.' : 'Prêtre créé avec succès.',
            'pretre' => $request->status,
        ], 201);
    }


    /**
     * Récupérer les détails d'un prêtre.
     */
    public function show($id)
    {
        $pretre = Pretre::with('diocese')->find($id);

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

    public function listPretres(Request $request)
    {

        $query = Pretre::with('diocese')
            ->orderBy('created_at', 'desc')
            ->where('status', 'active');

        // Recherche par nom, numéro ou email
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenoms', 'like', '%' . $search . '%')
                    ->orWhere('numero_telephone', 'like', '%' . $search . '%')
                    ->orWhere('adresse_electronique', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $pretres = $query->paginate(25);

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

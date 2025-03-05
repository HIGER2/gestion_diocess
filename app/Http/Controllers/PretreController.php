<?php

namespace App\Http\Controllers;

use App\Models\Diocese;
use App\Models\DiplomeAcademique;
use App\Models\DiplomeEcclesiastique;
use App\Models\ParcoursPastoral;
use App\Models\Pretre;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
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
            'lieu_affectation' => 'nullable',
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

        // load image
        $filePath = "";
        if ($request->hasFile('selectedFile')) {
            // Récupération de l'extension et génération d'un nom unique pour le fichier
            $extension = $request->file('selectedFile')->getClientOriginalExtension();
            $fileName = uniqid() . '_' . time() . '.' . $extension;

            // Stockage du fichier dans le répertoire 'uploads/dioceses' du disque public
            $filePath = $request->file('selectedFile')->storeAs('uploads/prete', $fileName, 'public');
        }

        // Générer le matricule
        $request['matricule'] = $this->generateMatricule(
            $abbreviation,
            $validated['nom'],
            $validated['prenoms']
        );



        if ($request->id) {
            // Mise à jour
            $data = $request->except(['diocess', 'diplome_ecclesiastique', 'diplome_academique']);

            $diplome_ecclesiastique = $request->except('diplome_ecclesiastique');
            $diplome_academique = $request->except('diplome_academique');
            // Update the record using the filtered data
            if ($filePath) {
                $data['profile_path'] = $filePath;
            }
            $pretre = Pretre::findOrFail($request->id);
            $pretre->update($data);

            if (
                $request->has('lieu_affectation')
            ) {
                if (is_string($request->lieu_affectation)) {
                    $request->lieu_affectation = json_decode($request->lieu_affectation);
                }
                $pretre->lieuAffectation()->updateOrCreate(
                    ['pretre_id' => $pretre->id],
                    [
                        'nom' => $request->lieu_affectation->nom,
                        'date' => $request->lieu_affectation->date
                    ]
                );
            }

            if ($request->has('diplome_academique') && is_array($request->diplome_academique) &&  count($request->diplome_academique) > 0) {
                foreach ($request->diplome_academique as $key => $value) {
                    if (is_string($value)) {
                        $value = json_decode($value, true);
                    }
                    $pretre->diplome_academique()->updateOrCreate(
                        ['pretes_id' => $pretre->id, 'id' => $value['id'] ?? null],
                        [
                            'intitule_diplome' => $value['intitule_diplome'],
                            'date' => $value['date']
                        ]
                    );
                }
            }

            if ($request->has('diplome_ecclesiastique') && is_array($request->diplome_ecclesiastique) && count($request->diplome_ecclesiastique) > 0) {
                foreach ($request->diplome_ecclesiastique as $key => $value) {
                    if (is_string($value)) {
                        $value = json_decode($value, true);
                    }
                    $pretre->diplome_ecclesiastique()->updateOrCreate(
                        ['pretes_id' => $pretre->id, 'id' => $value['id'] ?? null],
                        [
                            'intitule_diplome' => $value['intitule_diplome'],
                            'date' => $value['date']
                        ]
                    );
                }
            }
        } else {
            // Création
            $request['profile_path'] = $filePath;
            $pretre = Pretre::create($request->except('lieuAffectation'));

            if (
                $request->has('lieu_affectation')
            ) {
                if (is_string($request->lieu_affectation)) {
                    $request->lieu_affectation = json_decode($request->lieu_affectation);
                }
                $request->lieu_affectation->pretre_id = $pretre->id;
                $pretre->lieuAffectation()->create([
                    'nom' => $request->lieu_affectation->nom,
                    'date' => $request->lieu_affectation->date
                ]);  // Créer la relation 'lieuAffectation' avec les données
            }

            if ($request->has('diplome_academique') && count($request->diplome_academique) > 0) {
                foreach ($request->diplome_academique as $key => $value) {
                    if (is_string($value)) {
                        $value = json_decode($value, true);
                    }
                    DiplomeAcademique::create([
                        'pretes_id' => $pretre->id,
                        'intitule_diplome' => $value['intitule_diplome'],
                        'date' => $value['date']
                    ]);
                }
            }

            if ($request->has('diplome_ecclesiastique')  && count($request->diplome_ecclesiastique) > 0) {
                foreach ($request->diplome_ecclesiastique as $key => $value) {
                    if (is_string($value)) {
                        $value = json_decode($value, true);
                    }
                    DiplomeEcclesiastique::create(
                        [
                            'pretes_id' => $pretre->id,
                            'intitule_diplome' => $value['intitule_diplome'],
                            'date' => $value['date'],
                        ]
                    );
                }
            }
        }


        return response()->json([
            'message' => $request->id ? 'Prêtre mis à jour avec succès.' : 'Prêtre créé avec succès.',
            'pretre' => $request->status,
            "path" => $filePath
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

        $query = Pretre::with(['diocese', 'lieuAffectation'])
            ->with("diplome_academique")
            ->with("diplome_ecclesiastique")
            ->orderBy('created_at', 'desc')
            ->where('status', 'active');

        // Recherche par nom, numéro ou email
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenoms', 'like', '%' . $search . '%')
                    ->orWhere('numero_telephone', 'like', '%' . $search . '%')
                    ->orWhere('adresse_electronique', 'like', '%' . $search . '%')
                    ->orWhere('specialite', 'like', '%' . $search . '%');
            });

            $query->orWhereHas('diplome_academique', function ($q) use ($search) {
                $q->where('intitule_diplome', 'like', '%' . $search . '%'); // Champ du diplôme à modifier selon ta base
            });
            $query->orWhereHas('diplome_ecclesiastique', function ($q) use ($search) {
                $q->where('intitule_diplome', 'like', '%' . $search . '%'); // Champ du diplôme à modifier selon ta base
            });

            if (is_numeric($search)) {
                $age = (int) $search; // Convertir en entier

                // Calculer les bornes de la date de naissance pour cet âge
                $dateDebut = Carbon::now()->subYears($age + 1)->addDay(); // Date de naissance max (âge révolu)
                $dateFin = Carbon::now()->subYears($age); // Date de naissance min

                // Filtrer par âge
                $query->orWhereBetween('date_naissance', [$dateDebut, $dateFin]);
            }
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

    public function parcourt(Request $request)
    {
        $rules = [
            'date_debut' => 'required', // Le nom est obligatoire
            'date_fin' => 'required', // Le prénom est obligatoire
            'description' => 'required', // Vérifie que le rôle est valide
        ];
        $messages = [
            'date_debut.required' => 'Le champ "date_debut" est obligatoire.',
            'date_fin.required' => 'Le champ "date_fin" est obligatoire.',
            'description.required' => 'Le champ "description" est obligatoire.',
        ];

        $validator = $request->validate($rules, $messages);

        // Récupère le diocèse avec son ID
        $parcourt = ParcoursPastoral::Create($request->all());

        return response()->json([
            'parcourt' => $parcourt,
        ]);
    }
}
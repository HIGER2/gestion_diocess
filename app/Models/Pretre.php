<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pretre extends Model
{
    use HasFactory;
    protected $table = 'personnels';

    protected $fillable = [
        'nom',
        'prenoms',
        'matricule',
        'date_naissance',
        'dioceses_id',
        'lieu_naissance',
        'date_ordination_sacerdotale',
        'lieu_ordination_sacerdotale',
        'diplome_etude_ecclesiastique',
        'diplome_etude_profane',
        'numero_telephone',
        'adresse_electronique',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_ordination_sacerdotale' => 'date',
    ];
}

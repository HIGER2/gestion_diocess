<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pretre extends Model
{
    use HasFactory;

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
        'status'
    ];

    protected $casts = [
        'date_naissance' => 'date:Y-m-d',
        'date_ordination_sacerdotale' => 'date:Y-m-d',
    ];

    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'dioceses_id', 'id'); // Assure-toi que la clé étrangère est bien 'dioceses_id' dans la table 'pretres'
    }
}

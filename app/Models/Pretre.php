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
        'profile_path',
        'dioceses_id',
        'lieu_naissance',
        'date_ordination_sacerdotale',
        'lieu_ordination_sacerdotale',
        'diplome_etude_ecclesiastique',
        'diplome_etude_profane',
        'numero_telephone',
        'adresse_electronique',
        'communautaire',
        'specialite',
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

    public function lieuAffectation()
    {
        return $this->hasOne(LieuAffectation::class, 'pretre_id', 'id'); // Assure-toi que la clé étrangère est bien 'dioceses_id' dans la table 'pretres'
    }

    public function diplome_academique()
    {
        return $this->hasMany(DiplomeAcademique::class, 'pretes_id', 'id');
    }

    public function parcourt()
    {
        return $this->hasMany(ParcoursPastoral::class, 'pretre_id', 'id');
    }
    public function diplome_ecclesiastique()
    {
        return $this->hasMany(DiplomeEcclesiastique::class, 'pretes_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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


    static function loadForDiocese()
    {
        $user = Auth::user();
        if ($user && $user->role == 'admin' && $user->diocese) {
            return self::where('dioceses_id', $user->diocese->id);
        }
        return self::query();
    }

    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'dioceses_id', 'id'); // Assure-toi que la clé étrangère est bien 'dioceses_id' dans la table 'pretres'
    }

    public function parcours()
    {
        return $this->hasMany(LieuAffectation::class, 'pretre_id', 'id'); // Assure-toi que la clé étrangère est bien 'dioceses_id' dans la table 'pretres'
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && $user->diocese) {
                $model->dioceses_id = $user->diocese->id;
            }
        });
    }
}

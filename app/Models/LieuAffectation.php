<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LieuAffectation extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'date',
        'fonction',
        'date_fin',
        'dioceses_id',
        'pretre_id'
    ];

    public function pretre()
    {
        return $this->belongsTo(Pretre::class);
    }

    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'dioceses_id', 'id'); // Assure-toi que la clé étrangère est bien 'dioceses_id' dans la table 'pretres'
    }
}

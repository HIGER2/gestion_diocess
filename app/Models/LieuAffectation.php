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
}

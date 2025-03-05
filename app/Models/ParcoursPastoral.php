<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcoursPastoral extends Model
{
    protected $fillable = ['description', 'date_debut', 'date_fin', 'pretre_id'];

    public function pretre()
    {
        return $this->belongsTo(Pretre::class);
    }
}

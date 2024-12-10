<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiplomeAcademique extends Model
{
    protected $fillable = [
        'intitule_diplome',
        'pretes_id',
    ];
}

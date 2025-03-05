<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiplomeEcclesiastique extends Model
{
    protected $fillable = [
        'intitule_diplome',
        'date',
        'pretes_id',
    ];
}

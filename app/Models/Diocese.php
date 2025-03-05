<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diocese extends Model
{

    protected $fillable = [
        'diocese',
        'abreviation',
        'emplacement',
        'url_image'
    ];

    public function pretres()
    {
        return $this->hasMany(Pretre::class, 'dioceses_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diocese extends Model
{

    protected $fillable = [
        'diocese',
        'abreviation',
    ];

    public function pretres()
    {
        return $this->hasMany(Pretre::class, 'dioceses_id');
    }
}

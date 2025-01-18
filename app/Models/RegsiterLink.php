<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class RegsiterLink extends Authenticatable
{
    protected $table  = 'regsiter_links';

    protected $fillable = [
        'username',
        'password',
        'dioceses_id',
        'link',
        'status',
        'token',
        'expires_at'
    ];


    protected $hidden = [
        'password',
        'token',
    ];

    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'dioceses_id', 'id'); // Assure-toi que la clé étrangère est bien 'dioceses_id' dans la table 'pretres'
    }
}

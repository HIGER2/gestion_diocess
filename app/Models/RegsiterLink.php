<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && $user->diocese) {
                $model->dioceses_id = $user->diocese->id;
                $model->username = $user->diocese->abreviation;
            }
        });
    }
}

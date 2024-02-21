<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'telephone','pseudo','password','code_inscription','token','status','avatar','type_user','indicatif'
    ];

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'user_id', 'id');
    }

    public function destinationsCompagnie()
    {
        return $this->hasMany(DestinationCompagnie::class, 'user_id', 'id');
    }
}

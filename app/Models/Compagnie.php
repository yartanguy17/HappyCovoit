<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compagnie extends Model
{
    protected $table = 'compagnies';
    protected $fillable = [
        'denomination','user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function destinations()
    {
        return $this->hasMany(DestinationCompagnie::class, 'user_id', 'user_id');
    }
    public function abonnes()
    {
        return $this->hasMany(ClientSubscribeCompagnie::class, 'compagnie_id', 'id');
    }
}

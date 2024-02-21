<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    protected $table = 'chauffeurs';
    protected $fillable = [
        'nom','prenoms', 'immatriculation','type_vehicule','user_id','cni','status'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

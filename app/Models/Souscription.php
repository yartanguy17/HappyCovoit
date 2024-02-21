<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Souscription extends Model
{
     protected $table = 'souscriptions';
    protected $fillable = [
        'validite','expiration','date_souscription','prix', 'facture','reference','user_id','type'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function paiements()
    {
        return $this->hasMany(PaiementSouscription::class, 'souscription_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destinations';
    protected $fillable = ['id',
        'pays_destination','ville_destination','nbre_places','nbre_places_dispo', 'prix_unitaire','heure','pays_demarrage','ville_demarrage','date_demarrage','note','status','user_id','surcharge','is_confirmed'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

     public function reservations()
    {
        return $this->hasMany(Reservation::class, 'destination_id', 'id');
    }
    
}

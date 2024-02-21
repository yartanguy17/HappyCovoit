<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationCompagnie extends Model
{
    protected $table = 'destinations_compagnie';
    protected $fillable = ['id',
        'pays_destination','ville_destination','nbre_places','nbre_places_dispo', 'prix_unitaire','heure','pays_demarrage','ville_demarrage','jour','note','status','user_id'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'destination_id', 'id');
    }

    public function lignes()
    {
        return $this->hasMany(LigneDestination::class, 'destination_id', 'id');
    }

    public function annulations()
    {
        return $this->hasMany(DestinationAnnule::class, 'destination_id', 'id');
    }

    public function reservationsClient()
    {
        return $this->hasMany(ReservationClient::class, 'destination_id', 'id');
    }

}

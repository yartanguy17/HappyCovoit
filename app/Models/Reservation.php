<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
     protected $table = 'reservations';
    protected $fillable = [
        'date_reservation','nbre_places','prix_total','prix_total_commission', 'status_reservation','facture','status_siege','reference','destination_id','user_id','type_destination','is_signal','note','nbre_places_annules','date_depart','motif','ligne_destination_id'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function destination()
    {
        return $this->belongsTo('App\Models\Destination', 'destination_id');
    }

    public function destinationCompagnie()
    {
        return $this->belongsTo('App\Models\DestinationCompagnie', 'destination_id');
    }
    public function paiement()
    {
        return $this->hasMany(Paiement::class, 'reservation_id', 'id');
    }

    public function firstPaiement() {
        return $this->hasMany('App\Models\Paiement')->first();
    }

    public function sieges()
    {
        return $this->hasMany(ReservationSiege::class, 'reservation_id', 'id');
    }
}

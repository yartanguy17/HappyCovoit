<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationClient extends Model
{
     protected $table = 'reservations_clients';
    protected $fillable = [
       'destination_id','nbre_places', 'prix_total','date_reservation','prix_total', 'status_reservation','status_siege','facture','reference','client_id','date_depart','ligne_destination_id'
    ];


    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
    public function destination()
    {
        return $this->belongsTo('App\Models\DestinationCompagnie', 'destination_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationSiege extends Model
{
     protected $table = 'reservations_sieges';

    protected $fillable = [
        'numero','reservation_id','type_reservation'
    ];
}

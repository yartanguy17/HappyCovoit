<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationAnnule extends Model
{
     protected $table = 'destinations_annules';
    protected $fillable = [
        'date_annulation','destination_id'
    ];

    public function destination()
    {
        return $this->belongsTo('App\Models\DestinationCompagnie', 'destination_id');
    }
}

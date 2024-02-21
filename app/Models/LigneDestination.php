<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneDestination extends Model
{
     protected $table = 'lignes_destinations';
     protected $fillable = ['id','pays_destination','ville_destination', 'prix_unitaire','status','destination_id'
    ];

    public function destination()
    {
        return $this->belongsTo('App\Models\DestinationCompagnie', 'destination_id');
    }
}

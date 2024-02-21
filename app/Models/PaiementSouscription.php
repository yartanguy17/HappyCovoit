<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementSouscription extends Model
{
    protected $table = 'paiements_souscriptions';

    protected $fillable = [
        'identifier', 'tx_reference', 'amount','souscription_id','status','type','token'
    ];
}

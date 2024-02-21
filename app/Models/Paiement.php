<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'identifier', 'tx_reference', 'amount','reservation_id','status','type','token'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voyageur extends Model
{
    protected $table = 'voyageurs';
    protected $fillable = [
        'nom','prenoms', 'email','user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

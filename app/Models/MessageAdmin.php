<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageAdmin extends Model
{
    protected $table = 'messages_admin';


    protected $fillable = [
        'user_id', 'contenu','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

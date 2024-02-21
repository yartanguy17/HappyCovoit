<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSubscribeCompagnie extends Model
{
	protected $table = 'clients_subscribe_compagnies';
	protected $fillable = [
		'client_id','compagnie_id'
	];


	public function client()
	{
		return $this->belongsTo('App\Models\User', 'client_id');
	}
	public function compagnie()
	{
		return $this->belongsTo('App\Models\User', 'compagnie_id');
	}
}

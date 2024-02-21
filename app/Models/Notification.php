<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table = 'notifications';
	
	protected $fillable = [
		'titre','contenu','user_id','avatar','status'
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}

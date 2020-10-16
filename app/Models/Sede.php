<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
	// RELATIONS

	public function users()
	{
		return $this->belongsToMany(User::class)->withTimestamps();
	}

	// END RELATIONS
}

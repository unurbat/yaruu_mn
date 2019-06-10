<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Greeting extends Model
{
    public function angilal()
	{
		return $this->belongsTo('App\Angilal','category');
	}
}

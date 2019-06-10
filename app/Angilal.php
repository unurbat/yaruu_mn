<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angilal extends Model
{
    public function greetings()
	{
		return $this->hasMany('App\Greeting');
	}
}

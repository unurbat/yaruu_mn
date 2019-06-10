<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    public function authorinfo()
	{
		return $this->belongsTo('App\Author','author');
	}
}

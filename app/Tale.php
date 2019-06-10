<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tale extends Model
{
    public function authorinfo()
	{
		return $this->belongsTo('App\Author','author');
    }
    
    public function categoryinfo()
	{
		return $this->belongsTo('App\Category','category');
	}
}

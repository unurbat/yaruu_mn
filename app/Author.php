<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Author extends Model
{
    public function getAuthorInfo($id)
    {
        $info = DB::select('select * from authors where id = ?',[$id]);
        return $info;
    }
    public function poems()
	{
		return $this->hasMany('App\Poem');
    }
    public function tales()
	{
		return $this->hasMany('App\Tale');
    }
    public function cups()
	{
		return $this->hasMany('App\Cup');
    }
}

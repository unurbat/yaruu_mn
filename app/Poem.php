<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Poem extends Model
{
	public function authorinfo()
	{
		return $this->belongsTo('App\Author','author');
	}
	public function getTop10()
	{		
		//$top = DB::select('select * from (select * from (select * from (select page_id, sum(views) as total_views from pageviews where page_type = "poem" group by page_id)v order by v.total_views desc limit 10)aa left join (select p.*, a.name author_name, a.image author_img from poems p, authors a where p.author = a.id order by p.poem_views desc limit 10)bb on aa.page_id = bb.id)cc order by cc.total_views desc');
		
		//$top = DB::select('select * from (select * from (select * from (select page_id, sum(views) as total_views from pageviews where page_type = "poem" group by page_id)v order by v.total_views desc limit 10)aa left join (select p.*, a.name author_name, a.image author_img from poems p, authors a where p.author = a.id order by p.poem_views desc limit 10)bb on aa.page_id = bb.id)cc order by cc.total_views desc');

		$top = \App\Poem::orderBy('poem_views','desc')->limit(10)->get();
		
		return $top;
	}
	public function getLast10()
	{
		//$last = DB::select('select p.*, date(p.created_at) as trunced ,a.name author_name, a.image author_img from poems p, authors a where p.author = a.id order by p.created_at desc limit 10');

		//$last = DB::table('poems')->orderBy('created_at','desc')->limit(10);
		$last = \App\Poem::orderBy('created_at','desc')->limit(10)->get();
		return $last;
	}
	public function getSearcher($s_author, $s_content,$paginate)
	{
		
		if(empty($s_author)&&empty($s_content))
		{			
			// $poems = DB::table('poems')
			// ->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'poem' group by page_id)pageviews"), function($join) {
			// 	$join->on('poems.id', '=', 'pageviews.page_id');
			// })->leftjoin('authors','poems.author','=','authors.id')
			// ->select(DB::raw("poems.*, pageviews.views, authors.name as author_name, authors.image as author_img"))->paginate($paginate);							
			
			$poems = \App\Poem::orderBy('created_at','desc')->paginate($paginate);
		}			
		else	
		{			
			if(!empty($s_author)&&!empty($s_content))
			{
				// $poems = DB::table('poems')->where('author','=',$s_author)->where('content','like','%'.$s_content.'%')
				// 		->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'poem' group by page_id)pageviews"), function($join) {
				// 			$join->on('poems.id', '=', 'pageviews.page_id');
				// 		})->leftjoin('authors','poems.author','=','authors.id')
				// 		->select(DB::raw("poems.*, pageviews.views, authors.name as author_name, authors.image as author_img"))->paginate($paginate);
				
				$poems = \App\Poem::whereHas('authorinfo',function($q) use ($s_author){
					$q->where('id',$s_author);
				})->where('content','like','%'.$s_content.'%')->orderBy('created_at','desc')->paginate($paginate);
				
				$poems->appends(['author'=>$s_author,'searcher'=>$s_content]);								
			}
			else
			{
				if(!empty($s_author))
				{
					$col_name = 'author';
					$value = $s_author;
					$oper = '=';				
				}
				if(!empty($s_content))
				{
					$col_name = 'content';
					$value = '%'.$s_content.'%';
					$oper = 'like';			
				}	

				// $poems = DB::table('poems')->where($col_name,$oper,$value)
				// 		->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'poem' group by page_id)pageviews"), function($join) {
				// 			$join->on('poems.id', '=', 'pageviews.page_id');
				// 		})->leftjoin('authors','poems.author','=','authors.id')
				// 		->select(DB::raw("poems.*, pageviews.views, authors.name as author_name, authors.image as author_img"))->paginate($paginate);
				
				$poems = \App\Poem::where($col_name,$oper,$value)->orderBy('created_at','desc')->paginate($paginate);
				if(!empty($s_author))
				{				
					$poems->appends(['author'=>$s_author]);	
				}
				else
				{				
					$poems->appends(['searcher'=>$s_content]);	
				}				
			}			
		}		
		
		return $poems;
	}
}

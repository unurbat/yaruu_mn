<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Auth;

class CupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['author']))
        {          			
			// $cups = DB::table('cups')->where('author','=',$_GET['author'])
			// ->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'cup' group by page_id)pageviews"), function($join) {
			// 	$join->on('cups.id', '=', 'pageviews.page_id');
			// })->leftjoin('authors','cups.author','=','authors.id')
            // ->select(DB::raw("cups.*, pageviews.views, authors.name as author_name, authors.image as author_img"))->paginate(10);            
            
            $cups = \App\Cup::where('author',$_GET['author'])->orderBy('created_at','desc')->paginate(10);

            $cups->appends(['author'=>$_GET['author']]);
        }
        else
        {            
            // $cups = DB::table('cups')
			// ->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'cup' group by page_id)pageviews"), function($join) {
			// 	$join->on('cups.id', '=', 'pageviews.page_id');
			// })->leftjoin('authors','cups.author','=','authors.id')
            // ->select(DB::raw("cups.*, pageviews.views, authors.name as author_name, authors.image as author_img"))->paginate(10);

            $cups = \App\Cup::orderBy('created_at','desc')->paginate(10);
        }                           
        
        //$cups = DB::select('select p.*, a.name author_name, a.image author_img from poems p, authors a, pageviews v where p.author = a.id'.$add_condition);
        $authors = \App\Author::whereIn('id',DB::table('cups')->pluck('author'))->get();
        //$last = DB::select('select p.*, date(p.created_at) as trunced ,a.name author_name, a.image author_img from cups p, authors a where p.author = a.id order by p.created_at desc limit 10');

        $last = \App\Cup::orderBy('created_at','desc')->limit(10)->get();
        
        // $top = DB::select('select * from (select * from (select * from (select page_id, sum(views) as total_views from pageviews where page_type = "cup" group by page_id)v order by v.total_views desc limit 10)aa left join (select p.*, a.name author_name, a.image author_img from poems p, authors a where p.author = a.id order by p.poem_views desc limit 10)bb on aa.page_id = bb.id)cc order by cc.total_views desc');
        
        $top = \App\Cup::orderBy('cup_views','desc')->limit(10)->get();        
		
		if(Auth::check())
		{
			return view('admin.cup',['cups'=>$cups,'authors'=>$authors,'last'=>$last, 'top'=>$top,]);
		}
		else
		{
			return view('cup.index',['cups'=>$cups,'authors'=>$authors,'last'=>$last, 'top'=>$top,]);	
		}        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = DB::select('select * from authors');
        return view('cup.create',['authors'=>$authors]);
    }
	public function setComment(Request $request)
    {
        if($request->ajax())
        {
            $owner = 'Зочин';
            $parent_type = 3;
			
            if($request->input('comment_by')!= null)
            {
                $owner = $request->input('comment_by');
            }
            
            $com = new \App\Comments;
            $com->owner = $owner;
            $com->content = $request->input('comment_content');
            $com->parent_type = $parent_type;
            $com->address = $request->ip();
            $com->parent_id = $request->input('parent_id');
            $com->created_at = date('Y-m-d H:i:s');
            $com->updated_at = date('Y-m-d H:i:s');
            $com->save();
            
            $cup = \App\Cup::find($request->input('parent_id'));
            $cup->comments = $cup->comments + 1;
            $cup->save();
            
            return response()->json(\DB::select('select * from comments where parent_id = ? and parent_type = ? order by created_at desc',[$request->input('parent_id'),$parent_type]));
            
            //\DB::table('comments')->insert(['content'=>$_POST['comment_content'],'address'=>$_SERVER['REMOTE_ADDR'],'owner'=>'ajax']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cup = new \App\Cup;
		$cup->name = $request->input('name');
		$cup->author = $request->input('author');
		$cup->description = $request->input('bogino');
		$cup->content = $request->input('content');
		$cup->year = $request->input('year');
		$cup->created_at = date('Y-m-d H:i:s');
		$cup->updated_at = date('Y-m-d H:i:s');
		$cup->save();
		
		
		return redirect()->to('cup');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $ip_addr = $request->ip();
        $page_type = 'cup';
        $page_id = $id;
        $created_at = date('Y:m:d H:i:s');
        $exp_date = date('Y-m-d H:i:s',strtotime('+2 hour',strtotime($created_at)));
        
        $exists = \DB::table('pageviews')->where('page_type',$page_type)->where('ip_addr',$ip_addr)->where('page_id',$page_id)->exists();
        
        if($exists)
        {
            $expired = \DB::table('pageviews')->where('page_type',$page_type)
            ->where('ip_addr',$ip_addr)
            ->where('page_id',$page_id)
            ->where('exp_date','<',$created_at)
            ->exists();            

            if($expired)
            {
                \DB::table('pageviews')
                ->where('page_id', '=',$page_id)
                ->where('page_type','=',$page_type)
                ->where('ip_addr','=',$ip_addr)
                ->increment('views');
            
                \DB::table('cups')->where('id','=',$id)->increment('cup_views');
            
                \DB::table('pageviews')
                ->where('page_id', '=',$page_id)
                ->where('page_type','=',$page_type)
                ->where('ip_addr','=',$ip_addr)
                ->update(['exp_date'=>$exp_date]);
            }                        
        }
        else
        {
            \DB::table('pageviews')->insert(['ip_addr'=>$ip_addr,'page_type'=>$page_type,'page_id'=>$page_id,'created_at'=>$created_at,'exp_date'=>$exp_date,'views'=>1]);
            \DB::table('cups')->where('id','=',$id)->increment('cup_views');

        }
        
                
        //$views = \DB::table('pageviews')->where('page_type','=','cup')->where('page_id','=',$id)->get();
		
		
		//$views = DB::select("select page_id, sum(views) as views from pageviews where page_type='cup' and page_id = ? group by page_id",[$id]);
		
		$views = DB::table('pageviews')->select('page_id',DB::raw('sum(views) as total_views'))->groupBy('page_id')->where('page_type','=','cup')->where('page_id','=',$id)->first();
                
        
//        $add_views = 1;               
//        $cup = \App\Poem::find($id);
//        $cup->views = $cup->views+$add_views;
//        $cup->save();
        
        $cup = \App\Cup::find($id);
        
        $author = \App\Author::find($cup->author);   
        
        $comments = \DB::select('select * from comments where parent_id = ? and parent_type = 3 order by created_at desc',[$id]);
        $author_id = \DB::table('cups')->where('id','=',$id)->value('author');
        $related = \DB::table('cups')->where('author','=',$author_id)->where('id','<>',$id)->get();  
        $last = DB::select('select p.*, date(p.created_at) as trunced ,a.name author_name, a.image author_img from cups p, authors a where p.author = a.id order by p.created_at desc limit 10');
        $top = DB::select('select p.*, a.name author_name, a.image author_img from cups p, authors a where p.author = a.id order by p.cup_views desc limit 10');
        
		return view('cup.show',['cup'=>$cup,'author'=>$author,'comments'=>$comments, 'views'=>$views,'related'=>$related,'last'=>$last, 'top'=>$top,]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cup = \App\Cup::find($id);
        $authors = \App\Author::get();
        return view('cup.edit',['cup'=>$cup,'authors'=>$authors,'id'=>$id]);
		
//		$cup = \App\Tale::find($id);
//        $authors = \App\Author::get();
//        $categories = \App\Category::get();
//        return view('tale.edit',['tale'=>$cup,'authors'=>$authors,'id'=>$id,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cup = \App\Cup::findOrFail($id);
        $cup->name = $request->input('name');
        $cup->author = $request->input('author');
        $cup->content = $request->input('content');
        $cup->description = $request->input('bogino');
		$cup->year = $request->input('year');
		$cup->updated_at = date('Y-m-d H:i:s');
        $cup->save();
        
        return redirect()->to('cup');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Cup::findorFail($id)->delete();
		
		return redirect()->to('unorbat/cup');
    }
}

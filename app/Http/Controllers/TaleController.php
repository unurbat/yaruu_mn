<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Auth;

class TaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $pager = 10;
        if(isset($_GET['category']))
		{
			if(!empty($_GET['category']))
			{
				// $tales = DB::table('tales')->where('category','=',$_GET['category'])
				// ->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'tale' group by page_id)pageviews"), function($join) {
				// 	$join->on('tales.id', '=', 'pageviews.page_id');
                // })->paginate(5);
                
                $tales = \App\Tale::where('category',$_GET['category'])->orderBy('created_at','desc')->paginate($pager);
			}
		}
		elseif(isset($_GET['author']))
		{
			if(!empty($_GET['author']))
			{
				// $tales = DB::table('tales')->where('author','=',$_GET['author'])
				// ->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'tale' group by page_id)pageviews"), function($join) {
				// 	$join->on('tales.id', '=', 'pageviews.page_id');
                // })->paginate(5);
                
                $tales = \App\Tale::where('author',$_GET['author'])->orderBy('created_at','desc')->paginate($pager);
			}
		}
		elseif(isset($_GET['searcher']))
		{
			// $tales = DB::table('tales')->where('name','like','%'.$_GET['searcher'].'%')
			// 	->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'tale' group by page_id)pageviews"), function($join) {
			// 		$join->on('tales.id', '=', 'pageviews.page_id');
            //     })->paginate(5);
                
            $tales = \App\Tale::where('name','like','%'.$_GET['category'].'%')->orderBy('created_at','desc')->paginate($pager);
		}
		else
		{
			// $tales = DB::table('tales')
			// ->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'tale' group by page_id)pageviews"), function($join) {
			// 	$join->on('tales.id', '=', 'pageviews.page_id');
            // })->paginate(5);
            
            $tales = \App\Tale::orderBy('created_at','desc')->paginate($pager);
		}		         						
            
        $authors = \App\Author::whereIn('id',DB::table('tales')->pluck('author'))->get();
		
        $categories = \App\Category::get();
		
        // $last = DB::select('select p.*, date(p.created_at) as trunced ,a.name author_name, a.image author_img from tales p, authors a where p.author = a.id order by p.created_at desc limit 10');
        
		// $top = DB::select('select * from (select * from (select * from (select page_id, sum(views) as total_views from pageviews where page_type = "tale" group by page_id)v order by v.total_views desc limit 10)aa left join (select p.*, a.name author_name, a.image author_img from poems p, authors a where p.author = a.id order by p.poem_views desc limit 10)bb on aa.page_id = bb.id)cc order by cc.total_views desc');
        
        $last = \App\Tale::orderBy('created_at','desc')->limit(10)->get();
        
		$top = \App\Tale::orderBy('tale_views','desc')->limit(10)->get();
		

		if(Auth::check())
		{
			return view('admin.tale',['tales'=>$tales,'authors'=>$authors,'categories'=>$categories]);
		}
		else
		{
			return view('tale.index',['tales'=>$tales,'authors'=>$authors,'last'=>$last,'top'=>$top,'categories'=>$categories]);	
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
        $categories = DB::select('select * from categories'); 
        return view('tale.create',['authors'=>$authors,'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new \App\Tale;
        $model->name = $request->input('name');
        $model->category = $request->input('category');
        $model->author = $request->input('author');
        $model->description = $request->input('bogino');
        $model->content = $request->input('content');
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
        
        return redirect()->to('tale');
    }
    
    public function setComment(Request $request)
    {
        if($request->ajax())
        {
            $owner = 'Зочин';
			$parent_type = 2;
            
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
            
            $tale = \App\Tale::find($request->input('parent_id'));
            $tale->comments = $tale->comments + 1;
            $tale->save();
            
            return response()->json(\DB::select('select * from comments where parent_id = ? and parent_type = ? order by created_at desc',[$request->input('parent_id'),$parent_type]));
            
            //\DB::table('comments')->insert(['content'=>$_POST['comment_content'],'address'=>$_SERVER['REMOTE_ADDR'],'owner'=>'ajax']);
        }
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
        $page_type = 'tale';
        $page_id = $id;
        $created_at = date('Y:m:d H:i:s');
        $exp_date = date('Y-m-d H:i:s',strtotime('+2 hour',strtotime($created_at)));
        
        // $exists = \DB::select('select * from pageviews p  where p.page_type = ? and p.page_id = ? and p.ip_addr = ?',[$page_type,$page_id,$ip_addr]);
        
        // if(count($exists)>0)
        // {
        //     \DB::table('pageviews')
        //         ->where('page_id', '=',$page_id)
        //         ->where('page_type','=',$page_type)
        //         ->where('ip_addr','=',$ip_addr)
        //         ->where('exp_date','<',$created_at)
        //         ->increment('views');
            
        //     //\DB::table('tales')->where('id','=',$id)->increment('tale_views');
            
        //     \DB::table('pageviews')
        //         ->where('page_id', '=',$page_id)
        //         ->where('page_type','=',$page_type)
        //         ->where('ip_addr','=',$ip_addr)
        //         ->where('exp_date','<',$created_at)
        //         ->update(['exp_date'=>$exp_date]);
                        
        // }
        // else
        // {
        //     \DB::table('pageviews')->insert(['ip_addr'=>$ip_addr,'page_type'=>$page_type,'page_id'=>$page_id,'created_at'=>$created_at,'exp_date'=>$exp_date,'views'=>1]);    
        // }
        

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
            
                \DB::table('tales')->where('id','=',$id)->increment('tale_views');
            
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
            \DB::table('tales')->where('id','=',$id)->increment('tale_views');

        }
                
        $views = DB::table('pageviews')->select('page_id',DB::raw('sum(views) as total_views'))->groupBy('page_id')->where('page_type','=','tale')->where('page_id','=',$id)->first();
                
        
//        $add_views = 1;               
//        $tale = \App\Tale::find($id);
//        $tale->views = $tale->views+$add_views;
//        $tale->save();
        
        $tale = \App\Tale::find($id);		
        
        $author = \App\Author::find($tale->author);   
        
        $categories = DB::select('select * from categories');
		$authors = DB::select('select * from authors');
        
        $comments = \DB::select('select * from comments where parent_id = ? and parent_type = 2 order by created_at desc',[$id]);
        $author_id = \DB::table('tales')->where('id','=',$id)->value('author');
        $related = \DB::table('tales')->where('author','=',$author_id)->where('id','<>',$id)->get();  
        $last = DB::select('select p.*, date(p.created_at) as trunced ,a.name author_name, a.image author_img from tales p, authors a where p.author = a.id order by p.created_at desc limit 10');
        $top = DB::select('select p.*, a.name author_name, a.image author_img from tales p, authors a where p.author = a.id order by p.tale_views desc limit 10');
        
        return view('tale.show',['tale'=>$tale,'author1'=>$author,'comments'=>$comments, 'views'=>$views,'related'=>$related,'last'=>$last, 'top'=>$top,'categories'=>$categories,'authors'=>$authors]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tale = \App\Tale::find($id);
        $authors = \App\Author::get();
        $categories = \App\Category::get();
        return view('tale.edit',['tale'=>$tale,'authors'=>$authors,'id'=>$id,'categories'=>$categories]);
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
        $tale = \App\Tale::findOrFail($id);
        $tale->name = $request->input('name');
        $tale->author = $request->input('author');
        $tale->content = $request->input('content');
        $tale->description = $request->input('bogino');
        $tale->category = $request->input('category');
		$tale->updated_at = date('Y-m-d H:i:s');
        $tale->save();
        
        return redirect()->to('tale');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Tale::findOrFail($id)->delete();
        
        return redirect()->to('tale');
    }
}

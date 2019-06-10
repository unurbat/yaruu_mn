<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Auth;

class PoemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function getJson()
	{
		$poems = \App\Poem::all();
		
		return response()->json($poems);
	}
	
    public function index(Request $request)
    {
        $paginate = 16;
		$view = 'poem.index';
		$s_author = '';
		$s_content = '';
		
		$model = new \App\Poem;
		
		$top = $model->getTop10();
		$last = $model->getLast10();
		$authors = \App\Author::whereIn('id',DB::table('poems')->pluck('author'))->get();
		
		if(Auth::check())
		{	
			$paginate = 9;
			$view = 'admin.poem';
		}				
		
		if(isset($_GET['author'])&&!empty($_GET['author']))
		{ 
			$s_author = $_GET['author']; 
		}
		if(isset($_GET['searcher'])&&!empty($_GET['searcher']))
		{ 
			$s_content = $_GET['searcher'];
		}
		
		$poems = $model->getSearcher($s_author,$s_content,$paginate);			                		                				
				
		return view($view,['poems'=>$poems,'authors'=>$authors,'last'=>$last, 'top'=>$top,]);			  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        		
		$authors = DB::select('select * from authors');
        return view('poem.create',['authors'=>$authors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
		$model = new \App\Poem;
        $model->name = $request->input('name');
        $model->author = $request->input('author');
        $model->content = $request->input('content');
        $model->description = $request->input('bogino');
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
        
        return redirect()->to('poem');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {               
        $ip_addr = $request->ip();
        $page_type = 'poem';
        $page_id = $id;
        $created_at = date('Y:m:d H:i:s');
        $exp_date = date('Y-m-d H:i:s',strtotime('+2 hour',strtotime($created_at)));
        
        //$exists = \DB::select('select * from pageviews p  where p.page_type = ? and p.page_id = ? and p.ip_addr = ?',[$page_type,$page_id,$ip_addr]);

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
            
                \DB::table('poems')->where('id','=',$id)->increment('poem_views');
            
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
            \DB::table('poems')->where('id','=',$id)->increment('poem_views');

        }
        
                
        $views = DB::table('pageviews')->select('page_id',DB::raw('sum(views) as total_views'))->groupBy('page_id')->where('page_type','=','poem')->where('page_id','=',$id)->first();
                
        
//        $add_views = 1;               
//        $poem = \App\Poem::find($id);
//        $poem->views = $poem->views+$add_views;
//        $poem->save();
        
        $poem = \App\Poem::find($id);
        
        $author = \App\Author::find($poem->author);   
        
        $comments = \DB::select('select * from comments where parent_id = ? and parent_type = 1 order by created_at desc',[$id]);
        $author_id = \DB::table('poems')->where('id','=',$id)->value('author');
        $related = \DB::table('poems')->where('author','=',$author_id)->where('id','<>',$id)->get();  
        $last = DB::select('select p.*, date(p.created_at) as trunced ,a.name author_name, a.image author_img from poems p, authors a where p.author = a.id order by p.created_at desc limit 10');
        $top = DB::select('select p.*, a.name author_name, a.image author_img from poems p, authors a where p.author = a.id order by p.poem_views desc limit 10');
        
        return view('poem.show',['poem'=>$poem,'author'=>$author,'comments'=>$comments, 'views'=>$views,'related'=>$related,'last'=>$last, 'top'=>$top,]);
        
    }
    public function setComment(Request $request)
    {
        if($request->ajax())
        {
            $owner = 'Зочин';
			$parent_type = 1;
            
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
            
            $poem = \App\Poem::find($request->input('parent_id'));
            $poem->comments = $poem->comments + 1;
            $poem->save();
            
            return response()->json(\DB::select('select * from comments where parent_id = ? and parent_type = ? order by created_at desc',[$request->input('parent_id'),$parent_type]));
            
            //\DB::table('comments')->insert(['content'=>$_POST['comment_content'],'address'=>$_SERVER['REMOTE_ADDR'],'owner'=>'ajax']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poem = \App\Poem::find($id);
        $authors = \App\Author::get();
        return view('poem.edit',['poem'=>$poem,'authors'=>$authors,'id'=>$id]);
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
        $poem = \App\Poem::findOrFail($id);
        $poem->name = $request->input('name');
        $poem->author = $request->input('author');
        $poem->content = $request->input('content');
        $poem->description = $request->input('bogino');
		$poem->updated_at = date('Y-m-d H:i:s');
        $poem->save();
        
        return redirect()->to('poem');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Poem::findOrFail($id)->delete();
        
        return redirect()->to('poem');
    }
}

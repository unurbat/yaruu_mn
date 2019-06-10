<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
		if(isset($_GET['category'])){

            $category_id = $_GET['category'];
            //$greetings = DB::table('greetings')->where('category','=',$_GET['category'])->paginate(12);
            
            $greetings = \App\Greeting::whereHas('angilal',function($query) use($category_id){
                $query->where('id','=',$category_id);
            })->orderBy('created_at','desc')->paginate(24);
		}
		else
		{
			$greetings = \App\Greeting::orderBy('created_at','desc')->paginate(24);	
		}
		
		$angilals = \App\Angilal::get();
		
		if(Auth::check())
		{
			return view('admin.greeting',['greetings'=>$greetings,'angilals'=>$angilals]);
		}
		else
		{
			return view('greeting.index',['greetings'=>$greetings,'angilals'=>$angilals]);	
		}		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Angilal::get();
		return view('greeting.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new \App\Greeting;
		$model->category = $request->input('category');
		$model->desc = $request->input('bogino');
		$model->content = $request->input('content');
		$model->created_at = date('Y-m-d H:i:s');
		$model->updated_at = date('Y-m-d H:i:s');
		$model->save();
		
		return redirect()->to('greeting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $greeting = \App\Greeting::find($id);
		return view('greeting.show',['greeting'=>$greeting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $greeting = \App\Greeting::find($id);
		$angilals = \App\Angilal::get();
		return view('greeting.edit',['greeting'=>$greeting,'angilals'=>$angilals]);	
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
        $model = \App\Greeting::findOrFail($id);
		$model->category = $request->input('category');
		$model->desc = $request->input('bogino');
		$model->content = $request->input('content');		
		$model->updated_at = date('Y-m-d H:i:s');
		$model->save();
		
		return redirect()->to('greeting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Greeting::findOrFail($id)->delete();
		return redirect()->to('greeting');
    }
	
	public function getApi()
	{
		$greetings = DB::table('greetings')->join('angilals','angilals.id','=','greetings.category')->select('greetings.*','angilals.icon')->paginate(200);
		
        return response()->json($greetings);                
	}
	public function getDetail($id)
	{
		$greetings = DB::table('greetings')->where('greetings.id',$id)->paginate(1);
		
		return response()->json($greetings);
	}
}

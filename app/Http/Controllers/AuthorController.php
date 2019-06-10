<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use Validator;
use Input;
use File;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \Eventviva\ImageResize;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        		
		$authors = \App\Author::get();
        return view('author.index',['authors'=>$authors]);		
    }
	
	public function getAuthor(Request $request)
	{
		if($request->ajax())
        {                        
            $table_name = $request->input('model_name');
            $records = \DB::table($table_name)->pluck('author');
            $authors = \DB::table('authors')->where('name','like','%'.$request->input('author_name').'%')->whereIn('id',$records)->get();
            //return response()->json(\DB::select("select * from authors where name like '%".$request->input('author_name')."%'"));                       
            return response()->json($authors);
        }
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $val = Validator::make($request->all(),[
            'photo'=>'required|image|mimes:png,jpg,jpeg,gif',
            'name'=>'required|max:255',
            'bio'=>'required'
        ]);
                
        
        $img_folder = base_path().'/public/uploads/images/';
        $img_ext = $request->file('photo')->getClientOriginalExtension();        
        $img_new_name = md5(microtime(true));
        $img_db_name = strtolower($img_new_name).'.'.$img_ext;
        
        $model = new \App\Author;
        $model->name = $request->input('name');
        $model->bio = $request->input('bio');
        $model->image = $img_db_name;
        $model->save();
        
        
        $request->file('photo')->move($img_folder,$img_db_name);
        
        return redirect()->to('author');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = \App\Author::find($id);
        return view('author.show',['authors'=>$author]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //edit xuudas xaruulax
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
        //edit uildel xiix
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Author::findOrFail($id)->delete();
        return redirect()->to('author');
    }
}

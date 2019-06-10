<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AngilalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getJson()
	{
		$angilals = \App\Angilal::paginate(10);
		
		return \Response::json($angilals);
	}
	
	public function index()
    {
        $angilals = \App\Angilal::get();
		return view('angilal.index',['angilals'=>$angilals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('angilal.create');
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
        ]);
                
        
        $img_folder = base_path().'/public/uploads/images/';
        $img_ext = $request->file('photo')->getClientOriginalExtension();        
        $img_new_name = md5(microtime(true));
        $img_db_name = strtolower($img_new_name).'.'.$img_ext;
		
		
		$model = new \App\Angilal;
        $model->name = $request->input('name'); 
		$model->icon = $img_db_name;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
		
		$request->file('photo')->move($img_folder,$img_db_name);
		
        return redirect()->to('angilal');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $angilal = \App\Angilal::find($id);
		return view('angilal.edit',['angilal'=>$angilal]);
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
        $img_folder = base_path().'/public/uploads/images/';
        $img_ext = $request->file('photo')->getClientOriginalExtension();        
        $img_new_name = md5(microtime(true));
        $img_db_name = strtolower($img_new_name).'.'.$img_ext;
		
		$aniglal = \App\Angilal::findOrFail($id);
		
		$old_icon = $aniglal->icon;
		
        $aniglal->name = $request->input('name');
		$aniglal->icon = $img_db_name;
		$aniglal->updated_at = date('Y-m-d H:i:s');
        $aniglal->save();
        
		//$request->file('photo')->move($img_folder,$img_db_name);
		
		if($request->file('photo')->move($img_folder,$img_db_name))
		{
			unlink($img_folder.$old_icon);	
		}		
		
        return redirect()->to('angilal');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        \DB::table('comments')->insert(['content'=>$_POST['comment_content'],'address'=>$_SERVER['REMOTE_ADDR'],'owner'=>'Өнөрбат']);
        
//        $owner = $request->input('comment_by');
//        if(empty($owner))
//        {
//            $owner = 'Зочин';
//        }        
//        $comment = new \App\Comments;
//        $comment->content = $request->input('comment_content');
//        $comment->created_at = date('Y-m-d H:i:s');
//        $comment->owner = $owner;
//        $comment->address = $_SERVER['REMOTE_ADDR'];
//        $comment->parent_id = $request->input('parent_id');
//        $comment->parent_type = $request->input('parent_type');
//        $comment->save();
//        
//        $poem = \App\Poem::find($request->input('parent_id'));
//        $poem->comments = $poem->comments + 1;
//        $poem->save();
//        
//        return back()->with('success','Amjilttai');
    }    
}

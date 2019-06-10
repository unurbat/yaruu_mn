<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
     $authors = \App\Author::whereIn('id',DB::table('poems')->pluck('author'))->get();
	// // $poems = DB::table('poems')
	// // 		->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'poem' group by page_id)pageviews"), function($join) {
	// // 			$join->on('poems.id', '=', 'pageviews.page_id');
	// // 		})->leftjoin('authors','poems.author','=','authors.id')
    // //         ->select(DB::raw("poems.*, pageviews.views, authors.name as author_name, authors.image as author_img"))->paginate(20);							
	
	 $cups = \App\Cup::orderBy('created_at','desc')->paginate(10);

	// // $poems = DB::table('poems')
	// // 		->leftjoin(DB::raw("(select page_id, sum(views) as views from pageviews where page_type = 'poem' group by page_id)pageviews"), function($join) {
	// // 			$join->on('poems.id', '=', 'pageviews.page_id');
	// // 		})->leftjoin('authors','poems.author','=','authors.id')
    // //         ->select(DB::raw("poems.*, pageviews.views, authors.name as author_name, authors.image as author_img"))->paginate(8);
	
	 $last = \App\Cup::orderBy('created_at','desc')->limit(10)->get();
    
	 $top = \App\Cup::orderBy('cup_views','desc')->limit(10)->get();
	
	 return view('cup.index',['authors'=>$authors,'cups'=>$cups,'last'=>$last,'top'=>$top]);
	return 'Hello';
});
Route::get('/about','PagesController@getAbout');
Route::post('/comment','CommentsController@store')->name('comment');
Route::resource('tale','TaleController');
Route::resource('cup','CupController');
Route::resource('poem','PoemController');
Route::resource('greeting','GreetingController');
Route::post('/poem/comment','PoemController@setComment')->name('poem.comment');
Route::post('/tale/comment','TaleController@setComment')->name('tale.comment');
Route::post('/cup/comment','CupController@setComment')->name('cup.comment');
Route::post('/author/search','AuthorController@getAuthor')->name('author.search');
Route::get('/nopage',function(){
	return view('secure.nopage');
});
Route::get('/unorbat',function(){
	return view('admin.home');
});


/* ================== Homepage + Admin Routes ================== */



Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware'=>['auth']],function(){	
//	Route::resource('poem','PoemController',['only'=>['create','update','edit','store']]);		
	
	Route::resource('angilal','AngilalController');
	Route::resource('category','CategoryController');
	Route::resource('author','AuthorController');
	
	Route::resource('greeting','GreetingController',['except'=>['index','show']]);
	Route::resource('poem','PoemController',['except'=>['index','show']]);
	Route::resource('author','AuthorController',['except'=>['index','show']]);
	Route::resource('tale','TaleController',['except'=>['index','show']]);
	Route::resource('cup','CupController',['except'=>['index','show']]);
	Route::resource('category','CategoryController',['except'=>['index','show']]);
	Route::get('/unorbat/poem','PoemController@index')->name('admin.poem');
	Route::get('/unorbat/tale','TaleController@index')->name('admin.tale');
	Route::get('/unorbat/cup','CupController@index')->name('admin.cup');
	Route::get('/unorbat/greeting','GreetingController@index')->name('admin.greeting');
		
});

Route::get('angilals','AngilalController@getJson');
Route::get('api/greeting','GreetingController@getApi');
Route::get('api/greeting/{id}','GreetingController@getDetail');
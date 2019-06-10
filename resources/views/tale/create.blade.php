@extends('layouts.app')
@section('title','Өгүүллэг')
@section('sidebar')
    @parent
@endsection

@section('content')
    <h2>Өгүүллэг оруулах хэсэг</h2>
    <form action = "{{route('tale.store')}}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}        
        <div class="form-group">
            <label for="name">Өгүүллэгийн нэр:</label>
            <input class="form-control" name="name">       
        </div>
        <div class="form-group">
            <label for="category">Ангилал:</label>
            <select name="category">
                @if(!empty($categories))
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach                    
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="name">Зохиолчийн нэр:</label>
            <select name="author">
                @if(!empty($authors))
                    @foreach($authors as $author)
                        <option value="{{$author->id}}">{{$author->name}}</option>
                    @endforeach                    
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="name">Богино тайлбар:</label>
            <textarea class="form-control" name="bogino" id="desc_ta"></textarea>   
        </div> 
        <div class="form-group">
            <label for="name">Өгүүллэг:</label>
            <textarea class="form-control" name="content" id="content_ta"></textarea>       
        </div> 
        <div class="form-group">            
            <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
        </div>        
    </form>
<script>
	$().ready(function(){
		$('.myactive').removeClass('myactive');
		$('#tale_link').addClass('myactive');
	});
</script>
@endsection
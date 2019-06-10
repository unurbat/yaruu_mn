@extends('layouts.app')
@section('title','Өгүүллэг')
@section('sidebar')
    @parent
@endsection

@section('content')
    @if(isset($tale))
        <h2>Өгүүллэг засах хэсэг</h2>
        <form action = "{{route('tale.update', ['id' => $tale->id])}}" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Өгүүллэгийн нэр:</label>
                <input class="form-control" name="name" value="{{$tale->name}}">       
            </div> 
            <div class="form-group">
                <label for="name">Ангилал:</label>
                <select name="category">
                    @if(!empty($categories))
                        @foreach($categories as $category)
                            @if($tale->category == $category->id)
                                {{$text = 'selected'}}
                            @else
                                {{$text = ''}}
                            @endif
                            <option value="{{$category->id}}" {{$text}}>{{$category->name}}</option>
                        @endforeach                    
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="name">Зохиолчийн нэр:</label>
                <select name="author">
                    @if(!empty($authors))
                        @foreach($authors as $author)
                            @if($tale->author == $author->id)
                                {{$text = 'selected'}}
                            @else
                                {{$text = ''}}
                            @endif
                            <option value="{{$author->id}}" {{$text}}>{{$author->name}}</option>
                        @endforeach                    
                    @endif
                </select>
            </div>            
            <div class="form-group">
                <label for="name">Богино тайлбар:</label>
                <textarea class="form-control" name="bogino" id="desc_ta">{{$tale->description}}</textarea>                     
            </div> 
            <div class="form-group">
                <label for="name">Өгүүллэг:</label>
                <textarea class="form-control" name="content" id="content_ta">{{$tale->content}}</textarea>       
            </div> 
            <div class="form-group">            
                <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
            </div>        
        </form>
    @endif
	<script>
		$(document).ready(function(){
			$('.myactive').removeClass('myactive');
			$('#tale_link').addClass('myactive');
		});
	</script>
@endsection
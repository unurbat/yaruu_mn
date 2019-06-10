@extends('layouts.app')
@section('title','Шүлэг засварлах')
@section('sidebar')
    @parent
@endsection

@section('content')
    @if(isset($cup))
        <h2>Шүлэг засах хэсэг</h2>
        <form action = "{{route('cup.update', ['id' => $cup->id])}}" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Зохиолчийн нэр:</label>
                <select name="author">
                    @if(!empty($authors))
                        @foreach($authors as $author)
                            @if($cup->author == $author->id)
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
                <label for="name">Шүлгийн нэр:</label>
                <input class="form-control" name="name" value="{{$cup->name}}">       
            </div>
			<div class="form-group">
            	<label for="year">Хэдэн онд болор цом хүртсэн:</label>
            	<input class="form-control" name="year" value="{{$cup->year}}">       
        	</div>
            <div class="form-group">
                <label for="name">Богино тайлбар:</label>
                <textarea class="form-control" name="bogino" id="desc_ta">{{$cup->description}}</textarea>                     
            </div> 
            <div class="form-group">
                <label for="name">Шүлэг:</label>
                <textarea class="form-control" name="content" id="content_ta">{{$cup->content}}</textarea>       
            </div> 
            <div class="form-group">            
                <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
            </div>        
        </form>
    @endif
	<script>
		$(document).ready(function(){
			$('.myactive').removeClass('myactive');
			$('#cup_link').addClass('myactive');
		});
	</script>
@endsection
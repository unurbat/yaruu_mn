@extends('layouts.app')
@section('title','Шүлэг')
@section('sidebar')
    @parent
@endsection

@section('content')
    @if(isset($poem))
        <h2>Шүлэг засах хэсэг</h2>
        <form action = "{{route('poem.update', ['id' => $poem->id])}}" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Зохиолчийн нэр:</label>
                <select name="author">
                    @if(!empty($authors))
                        @foreach($authors as $author)
                            @if($poem->author == $author->id)
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
                <input class="form-control" name="name" value="{{$poem->name}}">       
            </div> 
            <div class="form-group">
                <label for="name">Богино тайлбар:</label>
                <textarea class="form-control" name="bogino" id="desc_ta">{{$poem->description}}</textarea>                     
            </div> 
            <div class="form-group">
                <label for="name">Шүлэг:</label>
                <textarea class="form-control" name="content" id="content_ta">{{$poem->content}}</textarea>       
            </div> 
            <div class="form-group">            
                <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
            </div>        
        </form>
    @endif
	<script>
		$(document).ready(function(){
			$('.myactive').removeClass('myactive');
			$('#poem_link').addClass('myactive');
		});
	</script>
@endsection
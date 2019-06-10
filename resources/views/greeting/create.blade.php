@extends('layouts.app')
@section('title','Мэндчилгээ')

@section('content')   
    <form action = "{{route('greeting.store')}}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}
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
            <label for="name">Богино тайлбар:</label>
            <textarea class="form-control" name="bogino" id="desc_ta"></textarea>   
        </div> 
        <div class="form-group">
            <label for="name">Агуулга:</label>
            <textarea class="form-control" name="content" id="content_ta"></textarea>       
        </div> 
        <div class="form-group">            
            <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
        </div>        
    </form>
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#greeting_link').addClass('myactive');
		});
	</script>
@endsection
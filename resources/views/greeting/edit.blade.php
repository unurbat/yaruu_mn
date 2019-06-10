@extends('layouts.app')
@section('title','Мэндчилгээ')

@section('content')   
    <form action = "{{route('greeting.update',['id'=>$greeting->id])}}" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
		<div class="form-group">
            <label for="category">Ангилал:</label>
            <select name="category">
                @if(!empty($angilals))
                    @foreach($angilals as $category)
						@if($category->id == $greeting->category)
							{{ $flag = 'selected' }}
						@else
							{{ $flag = '' }}
						@endif
                        <option value="{{$category->id}}" {{ $flag }}>{{$category->name}}</option>
                    @endforeach                 
                @endif
            </select>
        </div>		
        <div class="form-group">
            <label for="name">Богино тайлбар:</label>
            <textarea class="form-control" name="bogino" id="desc_ta">{{$greeting->desc}}</textarea>   
        </div> 
        <div class="form-group">
            <label for="name">Агуулга:</label>
            <textarea class="form-control" name="content" id="content_ta">{{$greeting->content}}</textarea>       
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
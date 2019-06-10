@extends('layouts.app')
@section('title','Ангилал')

@section('content')
	<h2>Ангилал засварлах хэсэг</h2>
    <form action = "{{route('angilal.update', ['id' => $angilal->id])}}" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Ангилалын нэр:</label>
            <input class="form-control" type="text" name="name" id="name" value="{{$angilal->name}}">
        </div>
		<div class="form-group">            
            <span>Зураг оруулах: </span><input type="file" name="photo">
        </div>
        <div class="form-group">            
            <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
        </div>        
    </form>
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#cat2_link').addClass('myactive');
		});
	</script>
@endsection
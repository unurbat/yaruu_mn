@extends('layouts.app')
@section('title','Ангилал')

@section('content')
	<h2>Ангилал нэмэх хэсэг</h2>
    <form action = "{{route('angilal.store')}}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Ангилалын нэр:</label>
            <input class="form-control" type="text" name="name" id="name">
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
@extends('layouts.app')
@section('title','Шинэ зохиолч нэмэх')
@section('sidebar')
    @parent
@endsection

@section('content')
    <h2>Зохиолчийн мэдээлэл нэмэх хэсэг</h2>
    <form action = "{{route('author.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Зохиолчийн нэр:</label>
            <input class="form-control" type="text" name="name" id="name">
        </div>
        <div class="form-group">            
            <span>Зураг оруулах: </span><input type="file" name="photo">
        </div>
        <div class="form-group">
            <label for="name">Зохиолчийн намтар:</label>
            <textarea class="form-control" name="bio" id="my_ta"></textarea>         
        </div> 
        <div class="form-group">            
            <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
        </div>        
    </form>
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#author_link').addClass('myactive');
		});
	</script>
@endsection
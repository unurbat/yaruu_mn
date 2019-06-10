@extends('layouts.app')
@section('title','Ангилал')
@section('sidebar')
    @parent
@endsection

@section('content')
    <h2>Ангилал нэмэх хэсэг</h2>
    <form action = "{{route('category.store')}}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Ангилалын нэр:</label>
            <input class="form-control" type="text" name="name" id="name">
        </div>        
        <div class="form-group">            
            <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
        </div>        
    </form>
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#cat1_link').addClass('myactive');
		});
	</script>
@endsection
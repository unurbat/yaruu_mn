@extends('layouts.app')
@section('title','Шүлэг оруулах')
@section('sidebar')
    @parent
@endsection

@section('content')
    <h2>Шүлэг оруулах хэсэг</h2>
    <form action = "{{route('cup.store')}}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}
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
            <label for="name">Шүлгийн нэр:</label>
            <input class="form-control" name="name">       
        </div>
		<div class="form-group">
            <label for="year">Хэдэн онд болор цом хүртсэн:</label>
            <input class="form-control" name="year">       
        </div>
        <div class="form-group">
            <label for="name">Богино тайлбар:</label>
            <textarea class="form-control" name="bogino" id="desc_ta"></textarea>   
        </div> 
        <div class="form-group">
            <label for="name">Шүлэг:</label>
            <textarea class="form-control" name="content" id="content_ta"></textarea>       
        </div> 
        <div class="form-group">            
            <input class="btn btn-sm btn-success" type="submit" name="tovch" value="Оруулах">
        </div>        
    </form>
	<script>
		$(document).ready(function(){
			$('.myactive').removeClass('myactive');
			$('#cup_link').addClass('myactive');
		});
	</script>
@endsection
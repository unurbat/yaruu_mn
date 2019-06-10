@extends('layouts.app')
@section('title','Шүлэг')
@section('sidebar')
    @parent
@endsection

@section('content')   
    <form action = "{{route('poem.store')}}" method="post"  enctype="multipart/form-data">
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
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#poem_link').addClass('myactive');
		});
	</script>
@endsection
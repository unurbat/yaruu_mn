@extends('layouts.app')

@section('title','Зохиолчид')

@section('sidebar')
    @parent
@endsection

@section('content')
    @if(!empty($authors))       
        <h3>{{$authors->name}}</h3>
        <img class="w-100" src="/uploads/images/{{ $authors->image }}">
        <p style="text-align:justify">{!!$authors->bio!!}</p>
    @else
        <h4>Medeelel oldsongui.</h4> 
    @endif
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#author_link').addClass('myactive');
		});
	</script>
@endsection
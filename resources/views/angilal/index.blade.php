@extends('layouts.app')
@section('title','Ангилал')

@section('content')
	<div class="row" style="margin-bottom:20px;">
		<div class="col-12">
			<a href="{{route('angilal.create')}}">
				<button class="btn btn-sm btn-primary"><i class="fas fa-plus-circle" style="font-weight:700;"></i>&nbsp;Шинэ ангилал нэмэх</button>
			</a>
		</div>
	</div>
	@if(isset($angilals))
	<div class="row">
		<div class="col-lg-12">
			<table width="100%">
				@foreach($angilals as $angilal)		
					<tr>
						<td><a href="{{route('angilal.edit',['id'=>$angilal->id])}}">{{$angilal->id}}</a></td>
						<td>							
							<img src="{{asset('uploads/images/'.$angilal->icon)}}">
						</td>
						<td>{{$angilal->name}}</td>
						<td><a href="{{route('angilal.edit',['id'=>$angilal->id])}}">Засах</a></td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
	@endif
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#cat2_link').addClass('myactive');
		});
	</script>
@endsection
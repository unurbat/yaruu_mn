@extends('layouts.app')
@section('title','Мэндчилгээ')

@section('content')
	<div class="row" style="margin-bottom:20px;">
		<div class="col-12">
			<a href="{{route('greeting.create')}}">
				<button class="btn btn-sm btn-primary"><i class="fas fa-plus-circle" style="font-weight:700;"></i>&nbsp;Шинэ мэдээ оруулах</button>
			</a>
		</div>
	</div>
	<div class="row">
	@if(isset($greetings))
		@foreach($greetings as $greeting)
			<div class="col-lg-4" style="height:220px; margin-top: 25px;">
				<div class="alert alert-warning" style="padding: 20px; text-align: center; height:inherit;">
					<div style="max-height:122px; overflow:hidden;">
						<table width="100%">
							<tr>
								<td style="color: #827A7D;"><hr style="color: black;"></td>
								<td width="30%" style="text-align:center">
								@foreach($angilals as $angilal)
									@if($greeting->category == $angilal->id)
										<img src="{{asset('uploads/images/'.$angilal->icon)}}">
									@endif
								@endforeach
								</td>
								<td><hr></td>
							</tr>
							<tr>
								<td colspan="3">{!! $greeting->desc !!}</td>
							</tr>							
						</table>
					</div>
					<div>
						<table width="100%">
							<tr>
								<td colspan="3"><hr style="padding:0px; margin:0px; margin-top:15px;"></td>
							</tr>
							<tr>
								<td>
									<form action="{{ route('greeting.destroy', ['id' => $greeting->id]) }}" method="post">
										<input type="hidden" name="_method" value="DELETE">
										{{ csrf_field() }}
										<button type="submit" style="font-size:10px;" class="btn btn-sm btn-danger" onclick="return confirm('Мэндчилгээг устгах уу?')"><i class="fas fa-trash-alt"></i></button>									
									</form>
								</td>
								<td></td>
								<td align="center" style="padding-top:15px;"><a href="{{route('greeting.edit',['id'=>$greeting->id])}}" style="font-size:12px;">Цааш унших</a></td>
							</tr>
						</table>
					</div>
				</div>				
			</div>
		@endforeach
	@endif	
	</div>
	<div class="row" style="margin-top:25px;">
		<div class="col-12">
			{{ $greetings->links()}}
		</div>
	</div>

	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#greeting_link').addClass('myactive');
		});
	</script>
@endsection
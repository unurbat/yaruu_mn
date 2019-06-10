@extends('layouts.master')
@section('title','Мэндчилгээ')
@section('meta_image',"http://yaruu.mn/uploads/images/yaruuhome.png")
@section('meta_title',"yaruu.mn | Мэндчилгээний үг | Төрсөн өдрийн мэндчилгээ | Шинэ жилийн мэндчилгээ | Хайрын мэндчилгээ ")
@section('meta_url','http:://yaruu.mn/greeting')
@section('meta_desc',"yaruu.mn | Мэндчилгээний үг | Төрсөн өдрийн мэндчилгээ | Шинэ жилийн мэндчилгээ | Хайрын мэндчилгээ ")
@section('sidebar')
<div class="sidebar_h1" style="margin:0px;">
    АНГИЛАЛ
</div>
<div class="sidebar_cat">
    @foreach($angilals as $angilal)
    <li class="greeting_list" style="padding-top:8px;">
        <a href="{{route('greeting.index',['category'=>$angilal->id])}}">
			<img src="{{asset('uploads/images/'.$angilal->icon)}}">&nbsp;&nbsp;{{$angilal->name}}
		</a>          
    </li>        
    @endforeach
</div>
@endsection
@section('page_header')
	<h1 style="display:none">Мэндчилгээний үг | Мэндчилгээний үгс</h1>
@endsection
@section('content')	
	<div class="row">
	@if(isset($greetings))
		@foreach($greetings as $greeting)
			<div class="col-lg-4 col-md-6" style="height:215px; margin-bottom:20px;">
				<div class="alert alert-success" style="padding: 20px; text-align: center; height:inherit;">
					<div style="max-height:120px; overflow:hidden;">
						<table width="100%">
							<tr>
								<td style="color: #827A7D;"><hr style="color: black;"></td>
								<td width="30%" style="text-align:center">
									<img src="{{asset('uploads/images/'.$greeting->angilal->icon)}}">
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
								<td colspan="3" align="center" style="padding-top:15px;"><a href="{{route('greeting.show',['id'=>$greeting->id])}}" style="font-size:12px; color: grey">Цааш унших</a></td>
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
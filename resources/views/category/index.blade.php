@extends('layouts.app')

@section('title','Ангилал')

@section('sidebar')
    @parent
@endsection
@section('content')
	<div class="row" style="margin-bottom:20px;">
		<div class="col-12">
			<a href="{{route('category.create')}}">
				<button class="btn btn-sm btn-primary"><i class="fas fa-plus-circle" style="font-weight:700;"></i>&nbsp;Шинэ ангилал нэмэх</button>
			</a>
		</div>
	</div>
    <div class="row content-row">
        <div class="col-12">
            @if(!empty($categories))
            <table width="100%" class="table-bordered">
                @foreach($categories as $category)
                    <tr><td><a href="{{route('category.show',['id'=>$category->id])}}">{{$category->id}}</a>&nbsp;{{$category->name}}</td></tr>
                @endforeach
            </table>            
            @else
                <h4>Medeelel oldsongui.</h4> 
            @endif
        </div>        
    </div> 
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#cat1_link').addClass('myactive');
		});
	</script>
@endsection
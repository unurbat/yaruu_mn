@extends('layouts.app')

@section('title','Зохиолчид')
@section('css')
	<link rel="stylesheet" href="{{asset('css/back/author/index.css')}}">
@endsection
@section('sidebar')
    @parent
@endsection
@section('content')
	<div class="row" style="margin-bottom:20px;">
		<div class="col-12">
			<a href="{{route('author.create')}}">
				<button class="btn btn-sm btn-primary"><i class="fas fa-plus-circle" style="font-weight:700;"></i>&nbsp;Шинэ зохиолч нэмэх</button>
			</a>
		</div>
	</div>
    <div class="row">
         @if(!empty($authors))
            @foreach($authors as $author)
                <div class="col-sm-12 col-md-6 col-lg-4 author-box">
                    <div class="jumbotron shadow-sm bg-light">
                        <div class="row author-header">
                            <table class="w-100">
                                <tr>
                                    <td style="width:15%;">
                                        <div class="col-3 author-img-box rounded">
            <!--                                <img class="rounded-circle float-right" src="http://via.placeholder.com/64x64">-->
                                            <img class="float-right" src="{{asset('uploads/images/'.$author->image)}}">                               
                                        </div> 
                                    </td>
                                    <td class="w-75 align-middle">
                                        <div class="col-9 author-title">
                                            <a href="{{ route('author.show', ['id' => $author->id]) }}">{{$author->name}}</a>  
                                        </div> 
                                    </td>
                                </tr>
                            </table>                                                      
                        </div> 
                        <hr>
                        <div class="row">                            
                            <div class="col-12 author-desc-box">                                
                                <?php echo $author->bio;?>{{$author->bio}}                               
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-12 author-desc-box">                                
                                <form action="{{ route('author.destroy', ['id' => $author->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <button type="submit" style="font-size:10px;" class="btn btn-sm btn-danger" onclick="return confirm('Зохиолчийг устгах уу?')"><i class="fas fa-trash-alt"></i></button>									
                                </form>
                            </div>
                        </div>
                    </div>
                </div>          
            @endforeach
        @else
            <h4>Medeelel oldsongui.</h4> 
        @endif
    </div> 
	<script>
		$().ready(function(){
			$('.myactive').removeClass('myactive');
			$('#author_link').addClass('myactive');
		});
	</script>
@endsection
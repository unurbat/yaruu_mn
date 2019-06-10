@extends('layouts.app')

@section('title','Өгүүллэг')


@section('content')
<div class="row" style="margin-bottom:20px;">
		<div class="col-12">
			<a href="{{route('tale.create')}}">
				<button class="btn btn-sm btn-primary"><i class="fas fa-plus-circle" style="font-weight:700;"></i>&nbsp;Шинэ мэдээ оруулах</button>
			</a>
		</div>
	</div>
    @if(!empty($tales))
        @foreach($tales as $tale)  
            <div class="col-12" style="padding:0px; margin:0px; margin-bottom:15px;">
                <div style="max-height:100px; overflow:hidden;">
                    <a href="{{route('tale.edit',['id'=>$tale->id])}}" style="color:black; text-decoration: none;">
                        <table width="100%">                                                
                           <tr>                           
                                <td colspan="3">
                                    <table>
                                        <tr>
                                            <td rowspan="2">
                                                @foreach($authors as $author)
                                                    @if($author->id == $tale->author)
                                                        <img src="{{asset('uploads/images/'.$author->image)}}" style="max-height:50px; min-height:50px; max-width:50px; min-width:50px; border:2px solid #E5E5E5;" class="rounded">
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="font-size: 10px; padding:0px; padding-left:10px;">
                                                @foreach($authors as $author)
                                                    @if($tale->author == $author->id)                                       
                                                        <span>{{$author->name}}</span>
                                                    @endif
                                                @endforeach    
                                            </td>                                        
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <a href="{{ route('tale.edit',['id'=>$tale->id]) }}" style="color:black; font-size: 15px; font-weight: 700; padding: 0px 0px;">{{$tale->name}}</a>       
                                            </td>
											<td align="right">
												
											</td>
                                        </tr>
                                    </table>                                
                                </td>
                            </tr>                                                
                            <tr>
                                <td colspan="3">
                                    <span style="text-align:justify; font-size:14px;">
                                        {!!$tale->description!!}
                                    </span>

                                </td>
                            </tr>                            
                        </table>
                    </a>   
                </div>
                <div style="margin-top:10px;">
                    <table width="100%">
                        <tr style="font-size: 11px;">
                            <td>
                                <i class="fas fa-calendar-alt">&nbsp;{{substr($tale->created_at,0,10)}}&nbsp;</i>
                                <i class="fas fa-tag" style="font-weight: 900;">
                                    @foreach($categories as $category)
                                        @if($tale->category == $category->id)
                                            <span style="font-size: 11px; padding:0px; font-weight: 400;">{{$category->name}}&nbsp;</span>
                                        @endif
                                    @endforeach   
                                </i>
                                <i class="fas fa-eye">&nbsp;{{$tale->views}}</i>&nbsp;&nbsp;
                                <i class="far fa-comment">&nbsp;{{$tale->comments}}</i>
                            </td>
                            <td align="right">                                
                                <a href="{{route('tale.edit',['id'=>$tale->id])}}" style="color:black; font-size: 11px; font-weight: bold; text-decoretion:none;">
									 <button class="btn btn-sm btn-info" style="font-size:10px;"><i class="far fa-edit"></i></button>
								 </a>								
                            </td>
							<td align="right" width="4%">
								<form action="{{ route('tale.destroy', ['id' => $tale->id]) }}" method="post">
									<input type="hidden" name="_method" value="DELETE">
									{{ csrf_field() }}
									<button type="submit" style="font-size:10px;" class="btn btn-sm btn-danger" onclick="return confirm('Өгүүллэгийг устгах уу?')"><i class="fas fa-trash-alt"></i></button>									
								</form>
							</td>
                        </tr>
                        <tr><td colspan="3"><hr></td></tr>
                    </table>
                </div>
                                         
            </div>
        @endforeach
    @else
        <h4>Medeelel oldsongui.</h4> 
    @endif           
    <div class="row">
        <div class="col-12" style="text-align:center;">
            {{$tales->links()}}
        </div>         
    </div>
    <p><a href="{{route('tale.create')}}">Шинэ өгүүллэг оруулах</a></p>
   
	<script>
        $(document).ready(function() {
            $('.myactive').removeClass('myactive');  
            $('#tale_link').addClass('myactive');              
        });
    </script>

@endsection
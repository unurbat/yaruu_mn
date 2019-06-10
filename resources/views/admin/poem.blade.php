@extends('layouts.app')
@section('title','Шүлэг')
@section('css')
	<link rel="stylesheet" href="{{asset('css/front/poem/index.css')}}">
@endsection
@section('content')
	<div class="row" style="margin-bottom:20px;">
		<div class="col-12">
			<a href="{{route('poem.create')}}">
				<button class="btn btn-sm btn-primary"><i class="fas fa-plus-circle" style="font-weight:700;"></i>&nbsp;Шинэ мэдээ оруулах</button>
			</a>
		</div>
	</div>
    <div class="row content-row">
    @if(!empty($poems))
        @foreach($poems as $poem)  
            <div class="col-lg-4">				
                <div class="jumbotron poem-jumbo" style="padding: 30px;">                           
                    <div class="poem-box">
                        <table width="100%" id="admin_table">
                            <tr>
                                <td colspan="3" align="center">
                                    <span style="font-size:10px;">{{$poem->author_name}}</span>                                    
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <hr>
                                </td>  
                                <td align="center" style="width:auto;">
                                    <a href="{{ route('poem.edit',['id'=>$poem->id]) }}" style="color:black; font-size:14px; font-weight: 700; padding: 8px 0px;">{{$poem->name}}</a>
                                </td>
                                <td width="10%">
                                    <hr> 
                                </td>
                            </tr>                                      
                            <tr>
                                <td class="poem_content" colspan="3">
                                    <span style="text-align: center; font-size:14px;">{!!$poem->description!!}</span>
                                </td>
                            </tr>                                    
                        </table>
                    </div>
                    <hr/>
                    <div>
                        <table width="100%;" style="font-size:13px;">
							<tr>
								<td>
									<a href="{{route('poem.edit',['id'=>$poem->id])}}" style="color:black; font-size: 11px; font-weight: bold; text-decoretion:none;">
										 <button class="btn btn-sm btn-info" style="font-size:10px;"><i class="far fa-edit"></i></button>
									 </a>
								</td>
								<td width="50%">
									<i class="fas fa-calendar-alt" style="font-size: 11px;">&nbsp;{{$poem->created_at}}</i>
								</td>
								<td align="right">
									<form action="{{ route('poem.destroy', ['id' => $poem->id]) }}" method="post">
										<input type="hidden" name="_method" value="DELETE">
										{{ csrf_field() }}
										<button type="submit" style="font-size:10px;" class="btn btn-sm btn-danger" onclick="return confirm('Шүлгийг устгах уу?')"><i class="fas fa-trash-alt"></i></button>									
									</form> 
								</td>
							</tr>
                        </table>
                    </div>
                </div>              
            </div>
        @endforeach
    @else
        <h4>Medeelel oldsongui.</h4> 
    @endif        
    </div>    
    <div class="row">
        <div class="col-12" style="text-align:center;">
            {{$poems->links()}}
        </div>         
    </div>

    <script>
        $(document).ready(function() {
            $('.myactive').removeClass('myactive');  
            $('#poem_link').addClass('myactive');              
        });
    </script>

@endsection
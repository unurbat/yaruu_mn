@extends('layouts.master')
@section('title','Болор цом')
@section('meta_image',"http://yaruu.mn/uploads/images/yaruuhome.png")
@section('meta_title',"yaruu.mn | Болор цомын шүлгүүд | Болор цомын эзэд | Болор цом")
@section('meta_url','http:://yaruu.mn/cup')
@section('meta_desc',"yaruu.mn | Болор цомын шүлгүүд | Болор цомын эзэд | Болор цом")
@section('css')
	<link rel="stylesheet" href="{{asset('css/front/cup/index.css')}}">
@endsection
@section('sidebar')
@parent
<div class="sidebar_h1">
    ЗОХИОЛЧИЙН НЭРЭЭР
</div>
<div class="author_list_div">
	<div class="input-group">
		<input type="text" placeholder="Зохиолчийн нэр" id="finder_input">
		<div class="input-group-prepend">
		  	<div class="input-group-text"><i class="fas fa-search"></i></div>
		</div>
		<input type="hidden" id="search_token" value=" {{ csrf_token() }}"/>
	</div>
	<div id="author_list">
		@foreach($authors as $author)
		<li>
			<a href="{{route('cup.index',['author'=>$author->id])}}">{{$author->name}}</a>          
		</li>        
		@endforeach
	</div>
</div>
@endsection
@section('page_header')
	<h1 style="display:none">Болор цомын тэргүүн шүлгүүд</h1>
@endsection
@section('content')
    @if(!empty($cups))		
        @foreach($cups as $i=> $cup)	
				@if($i%2==0)
				<div class="row cup-box">				
					<div class="col-sm-12 col-md-6 col-lg-6 cup-image-box">						
						<table width="100%">                     
                            <tr>
                                <td>
									<a href="{{route('cup.show',['id'=>$cup->id])}}">
										<img style="100%" src="{{asset('uploads/images/'.$cup->authorinfo->image)}}">
									</a>
								</td>
                            </tr>                                                               
                        </table>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6 cup-text-box">						
						<div class="row">
							<div class="col-12 cup-title-box">
								<span class="author_h1">{{$cup->authorinfo->name}}</span><br/>
								<a class="cup-title" href="{{ route('cup.show',['id'=>$cup->id]) }}"><span class="title_h1">{{$cup->name}}</span></a>
								<!-- 						 -->
							</div>	
						</div>
						<div class="row">
							<div class="col-12" style="height:152px; overflow:hidden">
								<a href="{{route('cup.show',['id'=>$cup->id])}}" class="a-container">
									<span style="text-align: left; font-size:14px;">{!!$cup->description!!}</span>
								</a>
							</div>	
						</div>
						<div class="row">
							<div class="col-12">
								<a href="{{route('cup.show',['id'=>$cup->id])}}" class="a-container">
								<table width="100%">
									<tr>
										<td style="padding-top:20px;">
											<table>
												<tr>
													<td style="text-align:center">
														<i class="fas fa-trophy cup-icon"><span class="cup-year">&nbsp;{{$cup->year}}</span></i>																								 
													</td>
												</tr>
											</table>									 								
										</td>
										<td class="cup-author">									
											<span><i class="fas fa-eye">&nbsp;{{$cup->cup_views}}</i>&nbsp;&nbsp;<i class="far fa-comment">&nbsp;{{$cup->comments}}</i></span>             
										</td>
									</tr>
								</table>
								</a>
							</div>							
						</div>
					</div>
				</div>						
				@else	
				<div class="row cup-box">	
					<div class="col-sm-12 col-md-6 col-lg-6 cup-text-box">
						<div class="row">							
							<div class="col-12 cup-title-box">
								<span class="author_h1">{{$cup->authorinfo->name}}</span><br/>
								<a class="cup-title" href="{{ route('cup.show',['id'=>$cup->id]) }}"><span class="title_h1">{{$cup->name}}</span></a>						
							</div>	
						</div>
						<div class="row">
							<div class="col-12" style="height:152px; overflow:hidden">
								<a href="{{route('cup.show',['id'=>$cup->id])}}" class="a-container">
								 	<span style="text-align: left; font-size:14px;">{!!$cup->description!!}</span>
								</a>
							</div>	
						</div>
						<div class="row">
							<div class="col-12">
								<a href="{{route('cup.show',['id'=>$cup->id])}}" class="a-container">
									<table width="100%">
										<tr>
											<td style="padding-top:20px;">
												<table>
													<tr>
														<td style="text-align:center;">
															<i class="fas fa-trophy cup-icon"><span class="cup-year">&nbsp;{{$cup->year}}</span></i>
														</td>
													</tr>
												</table>									 								
											</td>
											<td class="cup-author">
												<span><i class="fas fa-eye">&nbsp;{{$cup->cup_views}}</i>&nbsp;&nbsp;<i class="far fa-comment">&nbsp;{{$cup->comments}}</i></span>             
											</td>
										</tr>
									</table>
								</a>
							</div>	
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6 cup-image-box">
						<a href="{{route('cup.show',['id'=>$cup->id])}}" class="a-container">
							<table width="100%">                           
								<tr>
									<td>
										<img src="{{asset('uploads/images/'.$cup->authorinfo->image)}}" style="width:100%">
									</td>
								</tr>                                                               
							</table>
						</a>
					</div>
				</div>				
				@endif
				</a>	 	
        @endforeach
    @else
        <h4>Medeelel oldsongui.</h4> 
    @endif     
    <div class="row">
        <div class="col-12" style="text-align:center;">
            {{$cups->links()}}
        </div>         
    </div>

    <script>
        $(document).ready(function() {
            $('.myactive').removeClass('myactive');  
            $('#cup_link').addClass('myactive');              
        });
    </script>

	<script>
		$(document).ready(function(){		
			$('#finder_input').keyup(function(e){			
				e.preventDefault();
				$('#author_list li').remove();		
				$.ajaxSetup({
				  headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  }
				});	

				var search_token = $('#search_token').val();
				var my_url = "{{ route('author.search') }}";
				var author_name = $('#finder_input').val();

				$.ajax({
					type: 'post',
					data: 'author_name='+author_name+'&_token='+search_token+'&model_name=cups',
					url: my_url,                
					success:function(data)
					{                                         
						console.log(data);

						$(data).each(function(i, row) 
						{                  
							var base_url = "{{route('cup.index')}}";
							var my_href = base_url+'?author='+row.id;
							$("#author_list").append("<li><a style='color: black; font-size: 15px;' href='"+my_href+"'>"+row.name+"</a></li>");
						});
					}
				});

			});		
		});	
	</script>

@endsection

@section('sidebarlast')
    <div>
        @foreach($last as $per)
        <li class="sidebar_li">
            <a href="{{route('cup.show',['id'=>$per->id])}}">
                <table width="100%">
                    <tr>
                        <td rowspan="2" class="img_td">
                            <img src="{{asset('uploads/images/'.$per->authorinfo->image)}}" class="sidebar_img">   
                        </td>
                        <td rowspan="2" class="name_td">
                            {{$per->name}}
                        </td>
                        <td style="text-align:center;" width="30%">          
                            <i class="fas fa-calendar-alt" style="font-size: 10px; color: grey;"></i>
                        </td>
                    </tr>        
                    <tr>             
                        <td style="text-align:center; border-bottom: 1px dotted #F2F2F2;">
                            <span style="font-size: 10px;">{{$per->created_at}}</span>    
                        </td>
                    </tr>       
                </table>
            </a>            
        </li>        
        @endforeach
    </div>
@endsection

@section('sidebartop')
    <div>
        @foreach($top as $per)
        <li class="sidebar_li">
            <a href="{{route('cup.show',['id'=>$per->id])}}">
                <table width="100%">
                    <tr>
                        <td class="img_td">
                            <img src="{{asset('uploads/images/'.$per->authorinfo->image)}}" class="sidebar_img"> 
                        </td>
                        <td class="name_td">
                            {{$per->name}}   
                        </td>
                        <td class="sidebar_views">
                            <span style="font-size: 11px; color: grey;">
								<i class="fas fa-eye"><span style="color:black;">&nbsp;&nbsp;{{$per->cup_views}}</span></i>
							</span>
                        </td>
                    </tr>     
                </table>
            </a>            
        </li>              
        @endforeach   
    </div>
    <table style="margin-top: 8px; width: 100%">
        
    </table>
@endsection
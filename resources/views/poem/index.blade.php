@extends('layouts.master')
@section('title','Шүлэг|Shuleg|Яруу найраг|Yaruu nairag')
@section('meta_image',"http://yaruu.mn/uploads/images/yaruuhome.png")
@section('meta_title',"yaruu.mn | Шүлэг | Яруу найраг | Богино шүлгүүд | Гоё шүлэг | Хайрын шүлэг")
@section('meta_url','http:://yaruu.mn/poem')
@section('meta_desc',"yaruu.mn | Болор цомын шүлгүүд | Болор цомын эзэд | Болор цом")

@section('css')
	<link rel="stylesheet" href="{{asset('css/front/poem/index.css')}}">
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
			<a href="{{route('poem.index',['author'=>$author->id])}}">{{$author->name}}</a>          
		</li>        
		@endforeach
	</div>
</div>
@endsection
@section('page_header')
	<h1 style="display:none">Шүлэг | Яруу найраг | Богино шүлэг </h1>
@endsection
@section('content')
<div class="row" style="margin-bottom:10px;">
	<div class="col-12">
		<form method="get" action="{{route('poem.index')}}">
			<table width="100%">
				<tr>
					<td align="right">
						<div class="input-group" style="margin-bottom:20px;">
							<input type="text" class="form-control" name="searcher" style="font-size:13px; height:30px; padding:5px;" placeholder="Шүлгийн хэсгээс" value="<?php if(isset($_GET['searcher'])){echo $_GET['searcher'];}else { echo '';}?>">
							&nbsp;<input type="submit" class="btn btn-sm btn-default" value="Хайх" style="font-size: 11px;">
						</div>
					</td>
				</tr>
			</table>			
			
		</form>
	</div>
</div>
    <div class="row content-row">
    @if(!empty($poems))
        @foreach($poems as $poem)
		<div class="col-md-6 col-lg-6 poem-container">
		<a href="{{route('poem.show',['id'=>$poem->id])}}" class="a-container">
			<div class="jumbotron poem-jumbo">                           
				<div class="poem-box">
					<table width="100%">												
						<tr>
							<td class="poem_content" colspan="2">
								<span style="text-align:left">{!!$poem->description!!}</span>
							</td>
						</tr>						                             
					</table>
				</div>		
				<div style="padding-top: 50px;">
					<table width="100%">
					<tr>
						<td colspan="2"><hr></td>
					</tr>																		
						<tr>
							<td colspan="2">
								<span class="author_h1">{{$poem->authorinfo->name}}</span>                                   
							</td>
						</tr>
						<tr>							 
							<td colspan="2" style="padding-top:5px;">
								<span style="color:#56D1BF;" class="name-link"><span class="title_h1">{{$poem->name}}</span></span>
							</td>							
						</tr>
						<tr style="font-size:10px;">
							<td style="padding-top:10px;">
								<i class="fas fa-eye">&nbsp;{{$poem->poem_views}}</i>&nbsp;&nbsp;                           
							</td>
							<td style="text-align:right">							
                                <i class="far fa-comment">&nbsp;{{$poem->comments}}</i>
							</td>
						</tr>												                              
					</table>	
				</div>						
			</div>
			<div class="author-img">
				<img class="rounded-circle" style="height: 70px; width: 70px;" src="{{asset('uploads/images/'.$poem->authorinfo->image)}}">				
			</div>
			</a>
		</div>
        @endforeach
    @else
        <h4>Мэдээлэл олдсонгүй.</h4> 
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
                data: 'author_name='+author_name+'&_token='+search_token+'&model_name=poems',
                url: my_url,                
                success:function(data)
                {                                         
                    console.log(data);
					
					$(data).each(function(i, row) 
                    {                  
						var base_url = "{{route('poem.index')}}";
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
            <a href="{{route('poem.show',['id'=>$per->id])}}">
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
                            <span style="font-size: 10px;">{{date_format($per->created_at,'Y-m-d')}}</span>    
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
            <a href="{{route('poem.show',['id'=>$per->id])}}">
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
								<i class="fas fa-eye"><span style="color:black;">&nbsp;&nbsp;{{$per->poem_views}}</span></i>
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
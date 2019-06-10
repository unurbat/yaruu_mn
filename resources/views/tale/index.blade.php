@extends('layouts.master')
@section('title','Өгүүллэг')
@section('meta_image',"http://yaruu.mn/uploads/images/yaruuhome.png")
@section('meta_title',"yaruu.mn | Өгүүллэг | Шилдэг өгүүллэг | Богино өгүүллэг | Уянгын өгүүллэг")
@section('meta_url','http:://yaruu.mn/tale')
@section('meta_desc','yaruu.mn | Өгүүллэг | Шилдэг өгүүллэг | Богино өгүүллэг | Уянгын өгүүллэг')
@section('css')
	<link rel="stylesheet" href="{{asset('css/front/tale/index.css')}}">
@endsection
@section('sidebar')
@parent
<div class="sidebar_h1">
    АНГИЛАЛ
</div>
<div class="sidebar_cat">
    @foreach($categories as $category)
    <li class="tale_list">
        <a href="{{route('tale.index',['category'=>$category->id])}}">{{$category->name}}</a>          
    </li>        
    @endforeach   
</div>
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
			<a href="{{route('tale.index',['author'=>$author->id])}}">{{$author->name}}</a>          
		</li>        
		@endforeach
	</div>
</div>
@endsection
@section('page_header')
	<h1 style="display:none">Өгүүллэг | Богино өгүүллэг | Шилдэг өгүүллэг</h1>
@endsection
@section('content')
<div class="row" style="margin-bottom:10px;">
	<div class="col-12">
		<form method="get" action="{{route('tale.index')}}">
			<table width="100%">
				<tr>
					<td align="right">
						<div class="input-group" style="margin-bottom:20px;">
							<input type="text" class="form-control" name="searcher" style="font-size:13px; height:30px; padding:5px;" placeholder="Өгүүллэгийн нэр" value="<?php if(isset($_GET['searcher'])){echo $_GET['searcher'];}else { echo '';}?>">
							&nbsp;<input type="submit" class="btn btn-sm btn-default" value="Хайх" style="font-size: 11px;">
						</div>						
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>
    @if(!empty($tales))
        @foreach($tales as $tale)  
            <div class="col-12 tale_box">
                <div class="content_box">
                    <a href="{{route('tale.show',['id'=>$tale->id])}}" style="color:black; text-decoration: none;">
                        <table width="100%">                                                
                           <tr>                           
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td rowspan="2">
                                                <img src="{{asset('uploads/images/'.$tale->authorinfo->image)}}" class="rounded tale_img">
                                            </td>
                                            <td style="font-size: 10px; padding:0px; padding-left:10px;">
                                                <span class="author_h1">{{$tale->authorinfo->name}}</span>   
                                            </td>                                        
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <a href="{{ route('tale.show',['id'=>$tale->id]) }}" class="name_link"><span class="title_h1">{{$tale->name}}</span></a>      
                                            </td>
                                        </tr>
                                    </table>                                
                                </td>
                            </tr>                                                
                            <tr>
                                <td colspan="2">
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
                                <i class="fas fa-calendar-alt">&nbsp;{{$tale->created_at}}&nbsp;</i>
                                <i class="fas fa-tag" style="font-weight: 900;">
                                    <span style="font-size: 11px; padding:0px; font-weight: 400;">{{$tale->categoryinfo->name}}&nbsp;</span>   
                                </i>
                                <i class="fas fa-eye">&nbsp;{{$tale->tale_views}}</i>&nbsp;&nbsp;
                                <i class="far fa-comment">&nbsp;{{$tale->comments}}</i>
                            </td>
                            <td align="right">                                
                                <a href="{{route('tale.show',['id'=>$tale->id])}}" class="more_link">Цааш унших</a>
                            </td>
                        </tr>
                        <tr><td colspan="2"><hr></td></tr>
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

    <script>
        $(document).ready(function() {
            $('.myactive').removeClass('myactive');  
            $('#tale_link').addClass('myactive');              
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
					data: 'author_name='+author_name+'&_token='+search_token+'&model_name=tales',
					url: my_url,                
					success:function(data)
					{                                         
						console.log(data);

						$(data).each(function(i, row) 
						{                  
							var base_url = "{{route('tale.index')}}";
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
            <a href="{{route('tale.show',['id'=>$per->id])}}">
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
            <a href="{{route('tale.show',['id'=>$per->id])}}">
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
								<i class="fas fa-eye"><span style="color:black;">&nbsp;&nbsp;{{$per->tale_views}}</span></i>
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
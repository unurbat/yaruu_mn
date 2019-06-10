@extends('layouts.master')

@section('title',$author->name. ' - '.$poem->name)
@section('meta_title',$author->name. ' - '.$poem->name)
@section('meta_image',"http://yaruu.mn/uploads/images/".$poem->authorinfo->image)
@section('meta_url','http://yaruu.mn/poem/'.$poem->id)
@section('meta_desc',$author->name. ' - '.$poem->name)

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="show_content">        
        @if(!empty($poem))
        <h1 class="hidden_header">{{$poem->authorinfo->name}}&nbsp;{{$poem->name}}</h1>                    
        <table width="100%">
            <tr>                
                <td colspan="2" style="text-align: left;vertical-align:bottom;">
					<p style="font-size:15px; padding:0px; margin:0px;"><h2 class="author_h1">{{$poem->authorinfo->name}}</h2></p>
					<p class="show_name" style="padding:0px; margin:0px; color:#56D1BF;"><h3 class="title_h1">{{$poem->name}}</h3></p>                         
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr style="margin: 8px 0px;">
                </td>       
            </tr>
            <tr>
                <td width="50%"><img src="{{asset('uploads/images/'.$author->image)}}" class="w-100"></td>
                <td></td>
            </tr>
            <tr>                
                <td colspan="2" style="padding-top:20px; font-size: 15px;">                    
                    {!!$poem->content!!}
                </td>
            </tr>        
        </table>
        <table width="100%" style="margin:20px 0px;">
            <tr style="font-size:12px; color: grey;">
                <td>
                    <i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;{{$poem->created_at}}                  
                </td>
                <td align="right">
                    <i class="fas fa-eye"></i>&nbsp;&nbsp;{{$poem->poem_views}}&nbsp;                    
                </td>
            </tr>
        </table>                  
        @else
            <h4>Medeelel oldsongui.</h4> 
        @endif
    </div>

	<!-- ********************************************** Related NEWS ********************************************************** -->

    <div class="related-poems" style="width:100%; position:relative; overflow:hidden; display:block;">        
        @if(isset($related))
            @if(!empty($related))
                <table width="100%">
                    <tr>
                        <td style="text-align: center; font-size: 14px; border-bottom: 1px solid #56D1BF; background-color: #56D1BF; color: white; white-space: nowrap; padding: 3px 8px;">ХОЛБООТОЙ МЭДЭЭ</td>                
                    </tr>
                </table>
                <div class="parent_div">        
                    <div class="child_div">
                       @foreach($related as $row)
                        <li style="max-width:72px; min-width: 72px; margin:0px 10px 0px 0px;">
                            <a href="{{route('poem.show',['id'=>$row->id])}}">
                                <div class="related-img" style="border:1px solid grey;">
                                    <img src="{{asset('uploads/images/'.$author->image)}}" style="max-width:70px; max-height: 70px; min-width: 70px; min-height:70px;">
                                    <div class="related-name">{{$row->name}}</div>
                                </div>                                               
                            </a>
                        </li>
                    @endforeach
                    </div>
                    <ul style="height: 70px; line-height:70px;">
                        <li class="l_arrow"><i class="fas fa-angle-left" style="font-weight: 700; text-align:center;"></i></li>
                        <li class="r_arrow"><i class="fas fa-angle-right" style="font-weight: 700; text-align:center;"></i></li>
                    </ul>                    
                </div>                                    
            @endif             
        @endif
    </div>
	
	<!-- ********************************************** Comment BOX ********************************************************** -->

    <div class="comment-box">
        <table width="100%" style="margin-top:30px; margin-bottom:10px;">
            <tr>
                <td style="font-size: 14px; border-bottom: 1px solid #56D1BF; background-color: #56D1BF; color: white; white-space: nowrap; padding: 3px 8px;">
                    СЭТГЭГДЭЛ: <span id="comment_count" style="font-weight:bold;">{{$poem->comments}}</span>
                </td>                
            </tr>
        </table>              
        
		<!-- ********************************************** Comment Notif ********************************************************** -->
		
        <div style="font-size:12px;">
            <span style="color: red; font-weight: bold;">Анхааруулга: &nbsp;</span><span>Та сэтгэгдэл оруулахдаа бусдын нэр хүндэд халдах, ёс бус үг хэллэг ашиглах зэрэг үйлдэл гаргахгүй байхыг хүсье. Хэрэв дээрх хэв журмыг зөрчсөн тохиолдолд таны сэтгэгдэл устгагдах болно. <span style="font-weight:bold;">ЯРУУ.МН</span></span>         
        </div>
        <br>
		
		<!-- ********************************************** Comment FORM ********************************************************** -->
		
        <div style="background-color: #F2F2F2; padding: 20px;">
            <div class="form-group">
                <input class="form-control" type="text" name="comment_by" id= "comment_by" placeholder="Зочин" style="padding-left: 8px; width: 100%;" autocomplete="off"/>
                <input type="hidden" name="parent_id" id="parent_id" value="{{$poem->id}}"/>
                <input type="hidden" id="comment_token" value=" {{ csrf_token() }}"/>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="comment_content" id="comment_content" placeholder="Таны сэтгэгдэл..." style="padding-left: 8px; width: 100%; height:70px;"></textarea>
                <input type="submit" name="comment_btn" id="comment_btn" value="Оруулах" class="btn btn-sm btn-danger" class="form-control"/>
            </div>           
        </div>
    </div>
	
	<!-- ********************************************** Comment LIST ********************************************************** -->

    <div class="comments" style="margin:50px 0px;" id="comments">
        @foreach($comments as $comment)
        <table width="100%" style="margin: 20px 0px; border: 1px solid #D9D9D9; border-radius: 15px; border-collapse: separate;" id="comment_table">
            <tr style="color: grey; font-size: 11px;">
                <td style="padding-left:15px; text-align: left; border-bottom: 1px solid #F2F2F2; width: 50%;">
                    {{$comment->owner}}&nbsp;
                    @if(!empty($comment->address))
                        [{{$comment->address}}]
                    @endif
                </td>
                <td style="padding-right:15px; text-align: right; border-bottom: 1px solid #F2F2F2; width: 50%;">{{$comment->created_at}}</td>
            </tr>
            <tr>
                <td style="padding: 9px 15px; text-align: left; font-size: 13px; max-width:50px;" colspan="2" id="com_text">{{$comment->content}}</td>
            </tr>
        </table>    
        @endforeach
    </div>


	<script>
		 $.ajaxSetup({
			  headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
		$(document).ready(function()
		  {		
			$('.l_arrow').hide();
			$('.r_arrow').click(function()
			{                              
				$('.l_arrow').show();
				var pos = $('.child_div').position();
				var target_pos = pos.left-80;       
				var str_pos = target_pos+"px";
				$('.child_div').css("transform","translateX("+str_pos+")");          
			});
			$('.l_arrow').click(function()
			{            
				$('.r_arrow').show();
				var pos = $('.child_div').position();
				var target_pos = (parseInt(pos.left) + (80));       
				var str_pos = target_pos+"px";
				if(target_pos>=0)
				{
					$('.l_arrow').hide();
					$('.child_div').css("transform","translateX(0px)");
				}
				else
				{
					$('.child_div').css("transform","translateX("+str_pos+")");   
				}            
			});			

			$('#comment_btn').hide();
			$('#comment_content').keyup(function(){
			if($('#comment_content').val()&&$('#comment_content').val()!=' ')
			{
				$('#comment_btn').show();
			}
			else
			{
				$('#comment_btn').hide();
			}
			});                       

			$('#comment_btn').click(function(e){	
				e.preventDefault();
				var comment_by = $('#comment_by').val();
				var comment_content = $('#comment_content').val();            
				var parent_id = $('#parent_id').val();
				var comment_token = $('#comment_token').val();
				var my_url = "{{ route('poem.comment') }}";
				var comment_count = parseInt($('#comment_count').text());

				$.ajax({
					type: 'post',
					data: 'comment_by='+comment_by+'&comment_content='+comment_content+'&parent_id='+parent_id+'&_token='+comment_token,
					url: my_url,                
					success:function(data)
					{				
						console.log(data);                   
						$('#comment_by').val('');
						$('#comment_content').val('');
						$("#comments").find('table').remove();                    
						$(data).each(function(i, row) 
						{
							$("#comments").append('<table width="100%" style="margin: 20px 0px; border: 1px solid #D9D9D9; border-radius: 15px; border-collapse: separate;" id="comment_table"><tr style="color: grey; font-size: 11px;"><td style="padding-left:15px; text-align: left; border-bottom: 1px solid #F2F2F2; width: 50%;">'+row.owner+' ['+row.address+']</td><td style="padding-right:15px; text-align: right; border-bottom: 1px solid #F2F2F2; width: 50%;">'+row.created_at+'</td></tr><tr><td style="padding: 9px 15px; text-align: left; font-size: 13px; max-width:50px;" colspan="2" id="com_text">'+row.content+'</td></tr></table>');
						});			
						$('#comment_count').html(comment_count+1);
						$('#comment_btn').hide();
					}
				});
			});
			
			
			$('.myactive').removeClass('myactive');
			$('#poem_link').addClass('myactive');
			
			
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
                        <td rowspan="2" width="15%" style="padding: 8px 0px; border-bottom: 1px dotted #F2F2F2;">
                            <img src="{{asset('uploads/images/'.$per->author_img)}}" class="sidebar_img">   
                        </td>
                        <td rowspan="2" style="padding-left: 7px; border-bottom: 1px dotted #F2F2F2;" id="last_td">
                            {{$per->name}}
                        </td>
                        <td style="text-align:center;" width="30%">          
                            <i class="fas fa-calendar-alt" style="font-size: 10px; color: grey;"></i>
                        </td>
                    </tr>        
                    <tr>             
                        <td style="text-align:center; border-bottom: 1px dotted #F2F2F2;">
                            <span style="font-size: 10px;">{{$per->trunced}}</span>    
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
                        <td width="15%" style="padding: 8px 0px; border-bottom: 1px dotted #F2F2F2;">
                            <img src="{{asset('uploads/images/'.$per->author_img)}}" class="sidebar_img"> 
                        </td>
                        <td style="padding-left: 7px; border-bottom: 1px dotted #F2F2F2;" id="top_td">
                            {{$per->name}}   
                        </td>
                        <td style="border-bottom: 1px dotted #F2F2F2; text-align:right; width: 10%; padding-right:7px;">
                            <span style="font-size: 11px; color: grey;"><i class="fas fa-eye"><span style="color:black;">&nbsp;&nbsp;{{$per->poem_views}}</span></i></span><span></span>
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
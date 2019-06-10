<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="@yield('meta_title')">
        <meta name="description" content="@yield('meta_title')">				
		<meta name="title" content="@yield('title')" />

		<meta property="og:type" content="article">
		<meta property="og:title" content="@yield('meta_title')">
		<meta property="og:image" content="@yield('meta_image')">
		<meta property="og:url" content="@yield('meta_url')">
		<meta property="og:description" content="@yield('meta_desc')">
		<meta property="og:site_name" content="http://yaruu.mn">

        <title>ЯРУУ.МН - yaruu.mn @yield('title')</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
        <link href="{{asset('css/mystyle.css')}}" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        @yield('css')        
    </head>
    <body>        
        @yield('page_header')
		<section class="header-section">
			<nav class="navbar navbar-expand-sm navbar-expand-md navbar-expand-lg navbar-dark bg-dark" style="padding:0px;">				
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mymenu" aria-expanded="false" aria-controls="mymenu">
					<span class="navbar-toggler-icon open_btn" style="color:white;"></span>
					<span class="close_btn">
						<i class="fas fa-times" style="display: block; font-weight:700; font-size:20px; line-height:1.5em; height:1.5em; width:1.5em; vertical-align:middle;"></i>
					</span>					
				</button>
				<a class="navbar-brand" href="{{route('poem.index')}}"><img src="{{asset('uploads/images/yaruu.png')}}" style="height:inherit;">&nbsp;Яруу.МН</a>
				<div class="container" style="padding-top: 0px; padding-bottom:0px; height:inherit">                    
					<div class="collapse navbar-collapse" id="mymenu">
						<ul class="navbar-nav mr-auto main_ul">
                            <li class="nav-item" id="cup_link">
								<a class="nav-link" href="{{route('cup.index')}}" style="padding-left:10px;">
                                    <!-- <i class="fas fa-trophy" style="font-weight:700; color:#dad7d6; font-size:15px;"></i>     -->
                                    Болор цом&nbsp;                                    
								</a>
							</li>
							<li class="nav-item" id="poem_link">
								<a class="nav-link" href="{{route('poem.index')}}" style="padding-left:10px;">Шүлэг</a>
							</li>
							<li class="nav-item" id="tale_link">
								<div class="btn-group" style="padding:0px; margin:0px;">								
								  <a class="nav-link" href="{{route('tale.index')}}" style="padding: 18px 10px;">Өгүүллэг</a>
								  <span class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:18px 5px; padding-right:10px; cursor:pointer; color: white;">
									<span class="sr-only">Toggle Dropdown</span>
								  </span>
								  <div class="dropdown-menu">
									@foreach(\App\Category::get() as $row)
									 	<a class="dropdown-item" href="{{route('tale.index',['category'=>$row->id])}}">{{$row->name}}</a>
									@endforeach									
								  </div>
								</div>														
							</li>
							<li class="nav-item" id="greeting_link">
								<div class="btn-group" style="padding:0px; margin:0px;">								
								  <a class="nav-link" href="{{route('greeting.index')}}" style="padding: 18px 10px;">Мэндчилгээ</a>
								  <span class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:18px 5px; padding-right:10px; cursor:pointer; color: white;">
									<span class="sr-only">Toggle Dropdown</span>
								  </span>
								  <div class="dropdown-menu">
									@foreach(\App\Angilal::get() as $cat)
									 	<a class="dropdown-item" href="{{route('greeting.index',['category'=>$cat->id])}}">{{$cat->name}}</a>
									@endforeach								
								  </div>
								</div>														
							</li>							
						</ul>                
					</div>
				</div>				
			</nav>
		</section>
        <div class="container" style="min-height:1200px;">            
            <div class="row">                                
                <div class="col-lg-9">                
                    @yield('content')                  
                </div>  
                <div class="col-lg-3">
                    @section('sidebar')
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="last-tab" data-toggle="tab" href="#last" role="tab" aria-controls="last" aria-selected="true"><span><i class="far fa-clock"></i></span></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="top-tab" data-toggle="tab" href="#top" role="tab" aria-controls="top" aria-selected="false"><span><i style="font-weight: 700;" class="far fa-star"></i></span></a>
                          </li>                          
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade  show active" id="last" role="tabpanel" aria-labelledby="last-tab">
                                @yield('sidebarlast')              
                            </div>
                            <div class="tab-pane fade" id="top" role="tabpanel" aria-labelledby="top-tab">
                                @yield('sidebartop')                            
                            </div>                     
                        </div>
                    @show
                </div>
            </div>            
        </div>
        
        <section class="footer-section">
            <div class="container">
                <table width="100%;">                    
                    <tr>                                               
                        <td align="left" style="text-align:left; color:white;" width="50%">
                            <li><a href="{{url('/poem')}}">ШҮЛЭГ</a></li>
                            <li><a href="{{url('/tale')}}">ӨГҮҮЛЛЭГ</a></li>
                            <li><a href="{{url('/cup')}}">БОЛОР ЦОМ</a></li>
                            <li><a href="{{url('/greeting')}}">МЭНДЧИЛГЭЭ</a></li>                                         
                        </td>
                        <td width="50%" style="color:white; font-size:14px; font-style:italic; text-align:right;">
                            Вэб сайтын хөгжүүлэлтийг &nbsp;&copy;<a href="" style="color:white; font-weight:bold;">Simitlion LAB</a> 2018 он.   
                        </td>                        
                    </tr>                   
                </table> 
            </div>              
        </section>
        <section class="footer-header">
            <div class="container">
                <table width="100%;">
                    <tr>
                        <td colspan="2" style="color:white; font-size:14px; font-style:italic; text-align:center;">
                           Хүмүүний сэтгэлийг хөдөлгөж эс чадваас хөнгөн бийрийг хөших хэрэг юун.
                        </td>
                    </tr>                                      
                </table> 
            </div>              
        </section>
        <script>
            $(document).ready(function() {
              $('#content_ta,#desc_ta').summernote({
                  height: 200,               
              });                
            });
        </script>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ-@yield('title')</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>	

	<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
	<link href="{{asset('css/back/backstyle.css')}}" rel="stylesheet">
	@yield('css')
</head>
	
<body>
	<section class="header-section">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="min-height:50px; padding: 0px;">             
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>                
			<div class="container" style="padding-top: 0px; padding-bottom:0px;">                    
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto main_ul">							
						@if (!Auth::guest())
							<li class="nav-item" id="poem_link">
								<a class="nav-link" href="{{route('admin.poem')}}">Шүлэг</a>
							</li>
							<li class="nav-item" id="tale_link">
								<div class="btn-group">
								  <a class="nav-link" href="{{route('admin.tale')}}" style="padding:18px 10px;">Өгүүллэг</a>
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
								<div class="btn-group">
								  <a class="nav-link" href="{{route('admin.greeting')}}" style="padding:18px 10px;">Мэндчилгээ</a>
								  <span class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:18px 5px; padding-right:10px; cursor:pointer; color: white;">
									<span class="sr-only">Toggle Dropdown</span>
								  </span>
								  <div class="dropdown-menu">
									@foreach(\App\Angilal::get() as $row)
										<a class="dropdown-item" href="{{route('greeting.index',['category'=>$row->id])}}">{{$row->name}}</a>
									@endforeach									
								  </div>
								</div>														
							</li>
							<li class="nav-item" id="cup_link">
								<a class="nav-link" href="{{route('admin.cup')}}">
									<i class="fas fa-trophy" style="font-weight:700; color:#F3C723; font-size:15px;"></i>&nbsp;Болор цом
								</a>
							</li>
							<li class="nav-item" id="cat1_link">
								<a class="nav-link" href="{{route('category.index')}}">
									Ангилал өгүүллэг
								</a>
							</li>
							<li class="nav-item" id="cat2_link">
								<a class="nav-link" href="{{route('angilal.index')}}">
									&nbsp;Ангилал мэндчилгээ
								</a>
							</li>
							<li class="nav-item" id="author_link">
								<a class="nav-link" href="{{route('author.index')}}">
									&nbsp;Зохиолч
								</a>
							</li>
						@else
							<li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Нэвтрэх</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Бүртгүүлэх</a></li>								
						@endif
					</ul>
					<span>
						@if(!Auth::guest())
							<span style="color:yellow;">{{ Auth::user()->name }}&nbsp;</span>
							<a href="{{url('/logout')}}" class="nav-link" style="color:red; text-decoration: none; display:inline-block;">
								<i class="fas fa-power-off"></i>
							</a>	
						@endif
					</span>
				</div>
			</div>				
		</nav>
	</section>
	<div class="container">
		<div class="row" style="margin-top:25px;">
			<div class="col-12">
				@yield('content')
			</div>
		</div> 
	</div>  
	<script>
            $(document).ready(function() {
              $('#content_ta,#desc_ta').summernote({
                  height: 200,               
              });								
            });
        </script>
</body>
</html>

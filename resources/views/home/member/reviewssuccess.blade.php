<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>评价成功</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/headbase.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/home/member/reviewssuccess.css')}}" />
	@yield('css')
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('home/member/orderList')}}">
				<span class="left">					
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>	
				<span class="title" id="cent">评价成功</span>
			</div>
		</div>
		<img class="center" src="{{ asset('images/member/ping.png')}}" alt="" />
		<p>感谢您的评价!</p>
		<p>有您的支持我们会做的更好!</p>
	</body>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	@yield('js')
</html>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title')</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/headbase.css') }}" rel="stylesheet">
	@yield('css')
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<span class="left goback">
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				<span class="title" id="cent">@yield('headone')</span>
			</div>
		</div>
	</body>
	@yield('content')
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	@yield('js')
</html>
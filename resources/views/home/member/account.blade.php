<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>账户管理</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/account.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="javascript:" onclick="self.location=document.referrer;">
				<span class="left">				
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				 </span>
				 </a>
				<span class="title">账户管理</span>
			</div>
		</div>
		<div class="content">
			<div class="wraper top1">
			 <span >
			 	切换账户
			 </span>
			</div>
			<div class="wraper bg_white list ">
				<img class="pho" src=""/>
				<span>
					13744545444
				</span>
				<div class="picdiv">
				<img class="che" src="{{asset('images/member/checked.png')}}"/>
				</div>
			</div>
				<div class="wraper bg_white list ">
				<img class="pho" src=""/>
				<span>
					13845454545
				</span>
				<div class="picdiv">
				<img class="che" src="{{asset('images/member/checked.png')}}"/>
				</div>
			</div>
				<div class="wraper bg_white list ">
				<img class="pho" src=""/>
				<span>
					13978457869
				</span>
				<div class="picdiv">
				<img class="che" src="{{asset('images/member/check.png')}}"/>
				</div>
			</div>
			<div class="wraper bg_white list1">
			 <span>
			 	换个新账户登录
			 </span>
			</div>
		</div>
		
<!--		<div class="footer">
			<a href="#javascript:;">退出当前账户</a>
		</div>-->
	</body>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	<script src="{{asset('js/home/member/addressEdite.js')}}"></script>
	
</html>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>返利提现</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/cash/cash.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="javascript:" onclick="self.location=document.referrer;">
				<span class="left">
				
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>
				<span class="title">返利提现</span>
			</div>
		</div>
		<div class="content">
			<div class="wraper bg_white">
				<div class="info bg_white margin_top">
					<div class="common ">
						<span>提现余额:</span>
						<!--<input type="text" name="user" id="user" value="3366" />-->
						<p id="money">{{ $money }}</p>
					</div>
					<div class="common">
						<span>提现金额:</span>
						<p></p>
					</div>
					<div class="common1">
						<span>￥</span>
						<input type="text" name="detail" id="detail" value="" />
					</div>
					<div class="common2">
						<span>全部提现</span>
					</div>
				</div>
			</div>
		</div>
		<div class="ok">
			<a href="#javascript:;">提现</a>
		</div>

<!--		<div class="footer">
			<a href="#javascript:;">退出当前账户</a>
		</div>-->
	</body>
	<script>
		var url = "{{ url('/home/member/distribution') }}";
	</script>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	<script src="{{asset('js/member/cash.js')}}"></script>
	
</html>
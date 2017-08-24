<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>余额提现</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--		<link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">--}}
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
				<span class="title">余额提现</span>
			</div>
		</div>
		<div class="content">
			<div class="wraper bg_white">
				<div class="info bg_white margin_top">
					<div class="common ">
						<span>提现余额:</span>
						<!--<input type="text" name="user" id="user" value="3366" />-->
						<p class="total">{{$money}}</p>


					</div>
					<div class="common">
						<span>提现金额:</span>
						<input placeholder="请输入提现金额" type="text" name="cash" id="cash" value="" maxlength="13" onkeyup="value=value.replace(/[^\d]/g,'')" />
					</div>
					
					<div class="common">
						<span>提现方式:</span>
						<select name="type" id="type">
    						<option value="0" selected>支付宝</option>
    						<option value="1">微信</option>   
						</select>
					</div>
					<div class="common">
						<span>账号:</span>
						<input type="text" name="cash2"  id="cash2" value="" maxlength="20" placeholder="请输入账号"/>
					</div>
					<div class="common2">
						<span class="all">全部提现</span>
						<span class="cashNotice">提现金额需是100的倍数哦</span>
					</div>
				</div>
			</div>
		</div>
		<div class="ok">
			提现
		</div>

<!--		<div class="footer">
			<a href="#javascript:;">退出当前账户</a>
		</div>-->
	</body>
	<script>
        var url = "{{ url('/home/member/cash') }}";
	</script>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
{{--	<script src="{{asset('common/layer/layer.js')}}"></script>--}}
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	<script src="{{asset('js/member/cash.js')}}"></script>
	
</html>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>账户管理</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/headbase.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/home/member/usermanger.css')}}" />
	@yield('css')
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('home/member/set')}}">
				<span class="left">
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>
				<span class="title" id="cent">账户管理</span>
			</div>
		</div>
		<div class="user">
	<span>账户名称</span>
	<span class="name">{{ $data->name }}</span>
</div>
<div class="balance user ">
	<span>余额</span>
	<span class="yue">{{$data->virtualcurrency}}</span>
</div>
<a href="{{ url('/home/member/cash') }}">
<div class="balance user ">
	<span>可提现金额</span>
	<span class="yue">{{$data->virtualcurrency}}</span>
</div>
</a>
@if(!isset($data->pay_pass))
<a href="{{ url('/home/member/setzhi') }}">
<div class="recharge user ">	
	<span>设置支付密码</span>
	<span class="re-chong">></span>	
</div>
</a>
@else
<a href="{{ url('/home/member/xiugai') }}">
<div class="recharge user ">	
	<span>修改支付密码</span>
	<span class="re-chong">></span>	
</div>
</a>
@endif
<!--<a href="{{ url('/home/member/recharge') }}">
<div class="recharge user ">	
	<span>充值记录查询</span>
	<span class="re-chong">></span>	
</div>
</a>
<a href="{{ url('/home/member/withdrawals') }}">
<div class="recharge user ">	
	<span>充值</span>
	<span class="re-chong">></span>	
</div>
</a>-->
	</body>
	@yield('content')
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	@yield('js')
</html>

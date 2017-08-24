<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>我的钱包</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/headbase.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/home/member/usermanger.css')}}" />
	@yield('css')
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('home/member/myInfo')}}">
				<span class="left">
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>
				<span class="title" id="cent">我的钱包</span>
			</div>
		</div>
		<div class="balance user ">
			<span>余额</span>
			<span class="yue">{{$userInfo['virtualcurrency']}}</span>
		</div>
		<a href="{{ url('/home/member/cash') }}">
		<div class="balance user ">
			<span>可提现金额</span>
			{{--返利和充值的钱的总和--}}
			<span class="yue" >{{$userInfo['virtualcurrency']}}</span>
		</div>
		</a>
		<a href="{{ url('/home/member/recharge') }}">
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
		</a>
		<div class="recharge user ">
			<span>冻结保证金</span>
			<span class="re-chong">0.00</span>
		</div>
	   <div class="appbox">
		   <button class="appcash" id="appbtn">&nbsp;&nbsp;申请提现冻结金&nbsp;&nbsp;</button>
		   <span class="appstate">提现中</span><br/>
		   <span class="appwarn">提示：冻结金提现一周只能申请一次哦！</span>
	   </div>
	</body>
	@yield('content')
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	@yield('js')
</html>

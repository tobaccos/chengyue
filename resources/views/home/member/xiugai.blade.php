<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>修改支付密码</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/headbase.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/home/member/changepass.css')}}" />
 		<link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">

	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('home/member/usermanger')}}">
				<span class="left ">
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>
				<span class="title" id="cent">修改支付密码</span>
			</div>
		</div>
		<div class="yuan">
	<span>原密码</span>
	<input type="password" placeholder="请输入原密码" class="oldpwd"/>
	<strong class="yuanpass"></strong>
</div>

<div class="yuan">
	<span>新密码</span>
	<input type="password" placeholder="请输入新密码" class="pwd"/>
	<strong class="newpass"></strong>
</div>

<div class="yuan">
	<span>确认密码</span>
	<input type="password" placeholder="请输入原密码" name="password" id="password">
    <strong class="repass"></strong>
</div>
<div class="alert">
	<p>
		@if ($errors->has('password'))
		<span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
	@endif
	</p>
</div>

<div class="group">
	<button type="button" name="repassword" id="repassword" class="disabled">确认</button>
</div>
<a href="javascript:;"><p class="forget">点击找回密码</p></a>
<div class="kuang">
	您好链接已经发送到您的邮箱，请登录您的邮箱进行操作
</div>
<input type="hidden" name="" id="forgetInfo" value="" />
@if(session('info'))
	<div class="forgetInfo">
		<p>{{session('info')}}</p>
	</div>
@endif
	</body>
	@yield('content')
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	<script>
	//修改密码后台接口
	var url = "{{ url('/payPassUpdate') }}";
	var url1 = "{{ url('/home/member/usermanger') }}";
	var url2 = "{{ url('/send') }}";
	</script>
	<script src="{{asset('common/layer/layer.js')}}"></script>
	<script src="{{asset('js/member/xiugai.js')}}"></script>

</html>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>设置</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/set/set.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('home/member/myInfo')}}">
					<span class="left">				
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
			       </span>
				</a>				
				<span id="cent">设置</span>
			</div>
		</div>
		<div class="content">
			<a href="{{ url('/home/member/personal') }}">
				<div class="headImg bg_white padding_lr">
				<span class="t-photo">头像</span>
				<span class="float_r">
				<input type="hidden" name="img" id="img1" value="{{$data->pic}}" />
				@if($data->pic)
				<img class="phot" src="{{asset('uploads/user/')}}/{{$data->pic}}"/>
			 	@else
				<img class="phot" src="{{ asset('images/login/loginlogo.png')}}" alt="" />
			 	@endif
				
				</span>
				</div>
			</a>
			
			<a href="{{ url('/home/member/address') }}">
				<div class="bind common bg_white padding_lr">
				<span>收货地址</span>
				<span class="float_r"> > </span>
			</div>
			</a>
			<a href="{{ url('/home/member/usermanger') }}">
				<div class="bind common bg_white padding_lr">

				<span>账户管理</span>
				<span class="float_r"> > </span>
			</div>
			</a>
			<a href="{{ url('/home/member/changepass') }}">
				<div class="bind common bg_white padding_lr">

				<span>修改密码</span>
				<span class="float_r"> > </span>
			</div>
			</a>
			<a href="{{ url('/home/member/intro') }}">
				<div class="phone common bg_white padding_lr">

				<span>关于我们</span>
				<span class="float_r"> > </span>
			</div>
			</a>
			
			<!--<div class="phone common bg_white padding_lr">
			
				<span><a href="">客服</a></span>
				<span class="float_r"> > </span>
				
			</div>-->
			<a href="{{ url('/logout') }}"><div class="footer">退出当前账户</div></a>
	</body>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	<script src="{{asset('js/up/jquery.fileupload.js')}}"></script>
	<script src="{{asset('js/up/jquery.fileupload-process.js')}}"></script>
	<script src="{{asset('js/up/jquery.fileupload-validate.js')}}"></script>
	<script src="{{ asset('js/member/myInfo.js')}}"></script>
	
	
</html>
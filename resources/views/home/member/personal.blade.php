<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>个人信息</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/personal/personal.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('/home/member/myInfo')}}" >
				<span class="left">
				
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>
				<span class="title">个人信息</span>
			</div>
		</div>
		<div class="content">
			<div class="headImg bg_white padding_lr">
				<!--上传头像-->
				<form action="" id="uploadForm" enctype="multipart/form-data">
					<div class="upload">

						<div class="img_div" >
							<input type="hidden" name="img" id="img1" value="{{$data->pic}}" />
							@if($data->pic)
							<img  class="phot" src="{{asset('uploads/user')}}/{{ $data -> pic }}" style="width: 1.5rem;height: 1.5rem;">
							@else
							<img  src="{{ asset('images/login/loginlogo.png')}}" style="width: 1.5rem;height: 1.5rem; alt="" />
			 				@endif		
						</div>
										
					<a href="javascript:;" class="a-upload">
						<input type="file" name="myFile" id="myFile" multiple/>
					</a>
					</div>
				</form>

				<span class="a-photo">头像</span>
				<span class="float_r">
				</span>
			</div>
			<div class="userId bg_white padding_lr">

				<span >用户昵称</span>
				<span class="float_r">{{ $data -> name }}</span>
			</div>
			 @if($data->dls_apply == 2)
			<div class="twocode bg_white padding_lr">

				<span>二维码</span>
				<span class="float_r wei">
				<img src=" {{ asset('home/code') }}/{{  $data -> code}}" alt="" />
				</span>
			</div>
			@endif		
			
			<div class="phone bg_white padding_lr">

				<span>手机号</span>
				<span class="float_r">
				@if($data -> phone)
						{{ $data -> phone }}
					@else
						<span class="phone">
							未绑定
						</span>
					@endif

				</span>
			</div>
			@if(session('info'))
				<div class="phone bg_white padding_lr">
					<p class="colorInfo">{{session('info')}}</p>
				</div>
			@endif



			<div class="qq bg_white padding_lr">

				<span>QQ号</span>
				<span class="float_r">
				@if($data -> QQ)
						{{ $data -> QQ }}
					@else					
					<span class="qq">
							未绑定
						</span>
					@endif
				</span>
			</div>
			@if(session('info'))
				<div class="phone bg_white padding_lr">
					<p class="colorInfo">{{session('info')}}</p>
				</div>
			@endif
			<div class="email bg_white padding_lr">

				<span class="vicar">邮箱</span>
				<span class="float_r">
				@if($data -> email)
						<span class="vicar">{{ $data -> email }}</span>
					@else
						<span class="vicar">
							未绑定
						</span>
					@endif
				</span>
			</div>
			@if(session('info'))
				<div class="phone bg_white padding_lr">
					<p class="colorInfo">{{session('info')}}</p>
				</div>
			@endif
			<div class="kuang">	
</div>
<div class="shadw">
       <div class="head">
       	请输入正确邮箱已确保后期找回密码
       </div>
	   <form action="/home/member/email" method="post" id="myform1" onsubmit="return mySubmit(true)">
		   	{{csrf_field()}}
		   	<input type="email" name="email" placeholder="请输入正确邮箱" id="email">
		   <button class="sure" type="submit">确定</button>
		   <button class="quxiao" type="button">取消</button>
	   </form>
		
</div>
<div class="shadw2">
       <div class="head">
       	请输入正确手机号
       </div>
	   <form action="/home/member/phone" method="post" id="form1" >
		   	{{csrf_field()}}
		   	<input class="phone1 phone2" type="number" name="phone" placeholder="请输入正确手机号"  oninput="if(value.length>11)value=value.slice(0,11)">

		   <button class="sure" type="submit" id="myform2">确定</button>
		   <button class="quxiao" type="button">取消</button>
	   </form>
		
</div>
<div class="shadw3">
       <div class="head">
       	请输入qq号
       </div>
	   <form action="/home/member/QQ_add" method="post" id="form2" >
		   	{{csrf_field()}}
		   	<input type="number"class="qq1 phone2" name="qq" placeholder="请输入正确qq号"  oninput="if(value.length>11)value=value.slice(0,11)">
		   <button class="sure" type="submit" id="myform3">确定</button>
		   <button class="quxiao" type="button">取消</button>
	   </form>
		
</div>
<div class="shadw4">
       <div class="head">
       	请输入用户昵称
       </div>
	   <form action="/home/member/QQ_add" method="post"  >
		   	{{csrf_field()}}
		   	<input type="number"class="user1 phone2" name="qq" placeholder="请输入用户名"  >
		   <button class="sure" type="submit" id="myform4">确定</button>
		   <button class="quxiao" type="button">取消</button>
	   </form>
		
</div>
	</body>
	<script>
		  var url = "{{ url('/home/member/uploadImage') }}";
	</script>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	<script>
        var url = "{{ url('/home/member/uploadImage') }}";
	</script>
	<script src="{{asset('js/member/personal.js')}}"></script>
</html>
@extends('home.member.headbase')
@section('title')
修改密码
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/member/changepass.css')}}" />
 <link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">
@endsection
@section('headone')
修改密码
@endsection
@section('content')
<input type="hidden" name="token" value="{{ $token }}" id="token">
<div class="yuan">
	<span>邮箱地址</span>
	<input type="email" placeholder="请输入您的邮箱地址" class="oldpwd"/>
	<strong class="newpass"></strong>
</div>

<div class="yuan">
	<span>新密码</span>
	<input type="password" placeholder="请输入新密码" maxlength="20"  class="pwd"/>
	<strong class="newpass"></strong>
</div>

<div class="yuan">
	<span>确认密码</span>
	<input type="password" placeholder="请再次输入新密码" name="password" maxlength="20" id="password">
    <strong class="repass"></strong>
</div>
<div class="alert">
	<p></p>
</div>
<div class="group">
	<button type="button" name="repassword" id="repassword" class="disabled"  >确认</button>
</div>
@endsection
@section('js')
<script>
	//ajax接口
	var url = "{{ url('/toReset') }}";
	//跳转接口
	var url1 = "{{ url('logout') }}";
</script>
<script src="{{ asset('common/layer/layer.js')}}"></script>
<script src="{{ asset('js/home/loginres/reset.js')}}"></script>

@endsection
@extends('home.member.headbase')
@section('title')
设置支付密码
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/member/changepass.css')}}" />
 <link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">
@endsection
@section('headone')
设置支付密码
@endsection
@section('content')

<div class="yuan">
	<span>新密码</span>
	<input type="password" placeholder="请输入支付密码" class="pwd"/>
</div>

<div class="yuan">
	<span>确认密码</span>
	<input type="password" placeholder="请确认支付密码" name="password" id="password">

</div>
<div class="alert">
	<p></p>
</div>

<div class="group">
	<button type="button" name="repassword" id="repassword">确认</button>
</div>
@endsection
@section('js')
<script>
	//设置支付密码后台接口
	var url = "{{ url('/setPayPass') }}";
	var url1 = "{{ url('/home/member/usermanger') }}";
</script>
<script src="{{asset('common/layer/layer.js')}}"></script>
<script src="{{asset('js/member/xiugai.js')}}"></script>
@endsection

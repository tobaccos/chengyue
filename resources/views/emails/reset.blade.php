<!--<html>
    <head>
        <title>重置支付密码</title>
    </head>
    <body>
        <form action="{{ url('/resetPay') }}" method="post">
            {{ csrf_field() }}
            请输入支付密码<br>

            支付密码：<input type="password" name="password"><br>
            确认支付密码：<input type="password" name="password_confirmation"><br>

            <input type="submit" value="重置支付密码">
        </form>
    </body>
</html>-->
@extends('home.member.headbase')
@section('title')
重置支付密码
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/member/changepass.css')}}" />
<link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">
@endsection
@section('headone')
重置支付密码
@endsection
@section('content')
 <form action="{{ url('/resetPay') }}" method="post">
 {{ csrf_field() }}
<div class="yuan">
	<span>新密码</span>
	<input type="password" placeholder="请输入支付密码" name="password"   class="pwd"/>
</div>
	 @if(session('info'))
		 <div class="">
			 <p>{{session('info')}}</p>
		 </div>
	 @endif
<div class="yuan">
	<span>确认密码</span>
	<input type="password" placeholder="请确认支付密码" name="password_confirmation" id="password">

</div>
<div class="alert">
	<p></p>
</div>


<div class="group">
	<!--<input type="submit" value="重置支付密码">-->
	<button type="submit" name="repassword" id="repassword">确认</button>
</div>
 </form>
@endsection
@section('js')
<script>
	//设置支付密码后台接口
//	var url = "{{ url('/setPayPass') }}";
//	var url1 = "{{ url('/home/member/usermanger') }}";
</script>
<!--<script src="{{asset('common/layer/layer.js')}}"></script>
<script src="{{asset('js/member/setzhi.js')}}"></script>-->
@endsection
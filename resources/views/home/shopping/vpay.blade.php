@extends('home.member.headbase')
@section('title')
余额支付
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/member/withdrawals.css')}}" />
@endsection
@section('headone')
余额支付
@endsection
@section('content')
<div class="show">
	<span>账户余额</span>
	<span>
		<strong>￥</strong>
		<strong>{{$userInfo['virtualcurrency']}}</strong>
	</span>
</div>
<div class="jine show">
	<span>支付密码</span>
	
</div>
<div class="recharge show">
	<input type="password" placeholder="请输入支付密码" class="charges" />
</div>
@if(!empty($error))
<span class="error">{{$error}}</span>
@endif
<button class="btnn">确认支付</button>
<form action="" method="post" id="charges">
				{{csrf_field()}}
				<input type="hidden" name="pwd" id="data" value="data"/>
</form>
@endsection
@section('js')
<script src="{{asset('js/member/withdrawals.js')}}"></script>
@endsection
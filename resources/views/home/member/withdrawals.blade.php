@extends('home.member.headbase')
@section('title')
充值
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/member/withdrawals.css')}}" />
@endsection
@section('headone')
充值
@endsection
@section('content')
<div class="show">
	<span>可用余额:</span>
	<span>
		<strong>￥</strong>
		<strong>{{$userInfo['virtualcurrency']}}</strong>
	</span>
</div>
<div class="jine show">
	<span>充值金额:</span>
	<input type="text" placeholder="请输入充值金额" class="charges" maxlength="5" onkeyup="value=value.replace(/[^\d]/g,'')"/>
	
</div>

<div class="jine show">
	<span>请选择充值方式</span>
	<select name="type" id="type">
    	<option value="0" selected>支付宝</option>
    	<option value="1">微信</option>   
	</select>
	
</div>
<button class="btnn">充值</button>
<form action="" method="post" id="charges">
				{{csrf_field()}}
				<input type="hidden" name="price" id="data" value="data"/>
</form>
@endsection
@section('js')
<script src="{{asset('js/member/withdrawals.js')}}"></script>
@endsection
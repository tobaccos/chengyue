@extends('home.member.headbase')
@section('title')
余额支付失败
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/shopping/less.css')}}" />
@endsection
@section('headone')
余额支付失败
@endsection
@section('content')
@if(isset($_GET['state']))
	@if($_GET['state'] == 2)
<!--支付失败密码错误-->
<div class="less">
	<div class="yue"><img src="{{asset('images/shopping/falseaa.png')}}" alt="" /></div>
	<a href="{{$backUrl}}"> <img class="qita" src="{{asset('images/shopping/qita.png')}}" alt="" /></a>
	<a href="{{ url('home/member/xiugai')}}"><img class="falsea" src="{{asset('images/shopping/xiugai.png')}}" alt="" /></a>
</div>
@elseif($_GET['state'] == 1)
<!--支付失败余额不足-->
<div class="less">
	<div class="yue"><img src="{{asset('images/shopping/yue.png')}}" alt="" /></div>
	<a href="javascript:;"> <img class="qita goback" src="{{asset('images/shopping/qita.png')}}" alt="" /></a>
	<a href="{{ url('home/member/withdrawals')}}"><img class="falsea" src="{{asset('images/shopping/charge.png')}}" alt="" /></a>
</div>
@endif
@endif
@endsection
@section('js')
<script src="{{asset('js/member/less.js')}}"></script>
@endsection
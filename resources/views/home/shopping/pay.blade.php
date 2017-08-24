@extends('home.common.baseSingle')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/home/shopping/pay.css')}}" />
@endsection

@section('content')
    <div class="payChoose">
        <span class="chooseParWay"><img class="back" src="{{asset('images/base/back.png')}}">请选择支付方式</span>
        <div class="pricePay">订单号：<span class="redFont">{{substr($data, 0, 15)}}...</span></div>
        <span class="lineCCC"></span>
        <a class="zhiLink" href="{{url('home/shopping/alipay/'.$data)}}">
            <img class="zhiPay" src="{{asset('images/base/zhifubao.png')}}">
            支付宝支付
            <img class="rightCCC" src="{{asset('images/base/right.png')}}">
        </a>
        <span class="lineCCC"></span>
        <a class="weiLink" href="{{ url('wechat/'.$data) }}">
            <img class="weiPay" src="{{asset('images/base/payweixin.png')}}">
            微信支付
            <img class="rightCCC" src="{{asset('images/base/right.png')}}">
        </a>
        <!--加判断条件如果是充值的话就不显示-->
        <span class="lineCCC"></span>
         <a class="zhiLink" href="{{url('home/shopping/vpay/'.$data)}}">
            <img class="zhiPay" src="{{asset('images/base/zhifu.png')}}">
            余额支付
            <img class="rightCCC" src="{{asset('images/base/right.png')}}">
        </a>
        <span class="lineCCC"></span>
    </div>





@endsection

@section('js')
<script src="{{asset('js/goback.js')}}"></script>
@endsection
@extends('home.common.baseSingle')
@section('title')
    购物车
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/home/shopping/paySuccess.css')}}" />

@endsection
@section('content')
    {{--头部开始--}}
    <div class="headPart">
        <span class="payTitle">
            <a href="{{ url('/home/member/orderList') }}" class="return">
                <img class="back" src="{{asset('images/base/back.png')}}">
            </a>
            交易详情
        </span>
    </div>
    {{--头部结束--}}

    {{--中间支付结果内容--}}
    <div class="result">
        <div class="left">
            <img src="{{asset('images/base/paySuccess.png')}}">
        </div>
        <div class="right">
            <span class="payResult">付款成功啦！</span>
            <span class="note">本商城不会以付款异常为由要求您退款，谨防诈骗</span>
        </div>
        <div class="bottom">
            <a class="look" href="{{ url('/home/member/orderList?id=1') }}">查看订单</a>
            <a class="goOn" href="{{ url('/') }}">继续购物</a>
        </div>
    </div>
    {{--中间支付结果内容结束--}}

    {{--广告图--}}
    <div class="addsImg">
        <img src="">
    </div>
    <img src="">


    {{--产品列表显示几个就行--}}

    {{--产品列表暂时不放--}}


@endsection


@section('js')
    <script src="{{asset('js/goback.js')}}"></script>
@endsection
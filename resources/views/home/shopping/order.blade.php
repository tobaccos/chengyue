<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>确认订单</title>

    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/shopping/order.css') }}" rel="stylesheet">
</head>
<body>
<div class="headPart">
    <span class="orderTitle">
        <a href="{{url('home/product/proList/0')}}" class="return">
          <img src="{{asset('images/base/back.png')}}">
        </a>
        <span id="cent">
        	确认订单
        </span>
    </span>
</div>
<div class="line"></div>
{{--收货地址部分--}}
<div class="addressPart">
    @if(!empty($info))
        @foreach($info as $value)
        <span class="username fontSize">收货人：{{$value->name}}</span>
        <span class="userPhone fontSize">电话 : {{$value->phone}}</span>
        @endforeach
        <a class="right" href="{{ url('/home/shopping/payAddress') }}"><img src="{{asset('images/base/right.png')}}"></a>
        <span class="userAddress">{{$data['datas'][0]['addressStr']}}</span>
    @else
        
        <span class="fontSize">亲，您的地址好像丢了......</span>
        <a class="right" href="{{ url('/home/member/addressAdd') }}" ><img src="{{asset('images/base/right.png')}}"></a>
    @endif
</div>
<img class="redDot" src="{{asset('images/base/dot.png')}}">
{{--收货地址部分结束--}}

{{--产品区--}}
@foreach($data['datas'] as $keys=>$values)
<span class="proSort">产品所属分类：{{$values['typeName']}}</span>
<div class="line"></div>
<div class="proDetail">
    <img class="proImg" src="{{asset(PRO_IMG_PATH.$values['dataPro'][0]->thumbing)}}">
    <span class="proName">{{$values['dataPro'][0]->name}}</span><span class="proPrice">￥{{$values['price']}}</span>
    <div class="proParam">
        @foreach($values['attrNameVal'] as $key=>$value)
        <span>{{$key}} : {{$value}}</span>
        @endforeach
        @foreach($values['selfAttrObject'] as $k=>$v)
            <span>{{$k}} :
            @foreach($v as $vv)
            {{$vv}}&nbsp;
            @endforeach
            </span>
        @endforeach
    </div>
</div>
@endforeach
{{--产品区结束--}}
<form action="{{('handleOrder')}}" method="post">
    {{ csrf_field() }}
<input type="hidden" name="order_fsn" value="{{$data['order_fsn']}}" />
@foreach($data['datas'] as $v)
<input type="hidden" name="order_sn[]" value="{{$v['order_sn']}}" />
@endforeach
<div class="line"></div>
<span class="userNote">买家留言：</span><input class="noteContent" type="text" name="user_note" placeholder="备注"/>
<div class="line"></div>
<span class="allPrice"> ￥{{$data['allPrice']}}</span><span class="font">合计 :</span> <span class="proNum">共{{$data['num']}}件商品</span>
<div class="line"></div>
{{--产品区结束--}}

{{--底部--}}

<div class="footer">
    <div class="line" style="background: #ff3600;"></div>
    @if(!empty($info))
        <input type="hidden" name="address" value="{{$info[0]->id}}">
        <input type="hidden" name="info" value="{{$data['json']}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    @endif
        <button class="submitOrder">确认订单</button>


    <span class="shouldPay">总计 : ￥{{$data['allPrice']}}</span>
</div>
</form>


    <script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
    <script src="{{asset('js/rem.js')}}"></script>
    <script src="{{asset('js/goback.js')}}"></script>

</body>
</html>

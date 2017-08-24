<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>我的订单</title>
	
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home/member/orderList.css')}}" />
    @yield('css')

</head>
<body>
	<div class="header">
		<span class="left back">
				<img class="imgleft" src="{{asset('images/base/back.png')}}">
			</span>
		<span id="cent">我的订单</span>
		<span><i></i><i></i><i></i></span>
		<!--消息栏-->
		<span class="qqinfo">2</span>
	</div>
	<div class="hnav">
			<ul>
				<li class="hnavlist current">全部</li>
				<li class="hnavlist">待付款</li>
				<li class="hnavlist">待发货</li>
				<li class="hnavlist">待收货</li>
				<li class="hnavlist">待评价</li>
			</ul>
		</div>
		<!--代付款页面-->
	<div class="content" style="display: none;" id="daifu">
		
		<div class="con-goods">
			<div class="goods-header">
				<span><img src="{{ asset('images/shopping/true.png')}}" alt="" /></span>
				<span><img src="{{ asset('images/member/payx.png')}}" alt="" /></span>
				<span>印汇商盟</span>
				<span class="state">商品未付款</span>
			</div>
			<!--商品内容-->
			<div class="goods-pro">
				<span><img src="{{ asset('images/shopping/true.png')}}" alt="" /></span>
				<span><img src="" alt="" /></span>
			    <div class="pro-info">
			    	<p>名片制作 透明名片 高档仿金属
			    		防水名片制作</p>
			    	<p class="proxilie"><span>系列 : PVC透明名片</span> <span>规格 : 200张</span></p>
			    	<p class="price"><span class="now">￥130.00</span><span class="old">￥150.00</span> <strong>×</strong>
			    		<strong class="num">1</strong></p>
			    </div>
			    
			</div>
		</div>
		<!--结算-->
		<div class="banlance">
			<span><img src="{{ asset('images/shopping/false.png')}}" alt="" /></span>
			<label for="">全选</label>
			<span>合计 : </span>
			<span class="nowprice">￥130.00</span>
			<!--去结算-->
			<a href="" class="ban-go">去结算</a>		
		</div>		
	</div>
	<!--代发货页面-->	
	<div class="content" id="daifa">
		<div class="con-goods">
			<div class="goods-header">
				<span></span>
				<span><img src="{{ asset('images/member/payx.png')}}" alt="" /></span>
				<span>印汇商盟</span>
				<span class="state">买家已付款</span>
			</div>
			<!--商品内容-->
			<div class="goods-pro">
				<span></span>
				<span><img src="" alt="" /></span>
			    <div class="pro-info">
			    	<p>名片制作 透明名片 高档仿金属
			    		防水名片制作</p>
			    	<p class="proxilie"><span>系列 : PVC透明名片</span> <span>规格 : 200张</span></p>
			    	<p class="price"><span class="now">￥130.00</span><span class="old">￥150.00</span> <strong>×</strong>
			    		<strong class="num">1</strong></p>
			    </div>			    
			</div>
		</div>
		<!--合计-->
		<div class="heji">
			<span>共<stong>1</stong>件商品</span>
			<span>合计：</span>
			<strong class="str">￥</strong><span>130.00</span>
			<span class="fare">(含运费￥0.00)</span>
		</div>
	</div>	
	<!--待评价页面-->
	<div class="content" id="daiping">
		<div class="con-goods">
			<div class="goods-header">
				<span></span>
				<span><img src="{{ asset('images/member/payx.png')}}" alt="" /></span>
				<span>印汇商盟</span>
				<span class="state">已确认收货</span>
			</div>
			<!--商品内容-->
			<div class="goods-pro">
				<span></span>
				<span><img src="" alt="" /></span>
			    <div class="pro-info">
			    	<p>名片制作 透明名片 高档仿金属
			    		防水名片制作</p>
			    	<p class="proxilie"><span>系列 : PVC透明名片</span> <span>规格 : 200张</span></p>
			    	<p class="price"><span class="now">￥130.00</span><span class="old">￥150.00</span> <strong>×</strong>
			    		<strong class="num">1</strong></p>
			    </div>			    
			</div>
		</div>
		<!--评价-->
		<div class="pingjia">
			<span>共<stong>1</stong>件商品</span>
			<span>合计：</span>
			<strong class="str">￥</strong><span>130.00</span>
			<a href="" class="self">立即评价</a>
		</div>
	</div>	
<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/member/orderList.js')}}"></script>	
@yield('js')
</body>
</html>
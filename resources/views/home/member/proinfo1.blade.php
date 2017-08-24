<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>我的订单</title>	
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home/member/proinfo1.css')}}" />
    @yield('css')
</head>
<body>
	<div class="header">
			<span class="left back">
				<img class="imgleft" src="{{asset('images/base/back.png')}}">
			</span>
			<span>订单详情</span>
		</div>
	<section>
	<!--等待买家付款-->
		<div class="time" style="display: none;">
			<div class="t-left">
				<p>等待买家付款</p>
				<p class="times">剩<span>6</span>天<span>24</span>小时自动关闭</p>
			</div>
			<div class="t-right">
				<img src="{{asset('images/member/time.png')}}" alt="" />
			</div>
		</div>
		<!--买家已付款-->
		<div class="time" style="display: none;">
			<div class="t-left">
				<p>买家已付款</p>
				<p class="times">剩<span>6</span>天<span>24</span>自动确认</p>
			</div>
			<div class="t-right">
				<img src="{{asset('images/member/yifahuo.png')}}" alt="" />
			</div>
		</div>
		<!--买家已发货-->
		<div class="time">
			<div class="t-left">
				<p>卖家已发货</p>
				<p class="times">剩<span>6</span>天<span>24</span>自动确认</p>
			</div>
			<div class="t-right">
				<img src="{{asset('images/member/yifahuo.png')}}" alt="" />
			</div>
		</div>
	</section>
	<section>
		<div class="s-info">
			<img src="{{asset('images/member/jf.png')}}" alt="" />
			<p><span>收货人:</span><span></span> <strong class="tel"></strong></p>
			<p><span>收货地址：kjfkhagfkoasdjgagoijnasd</span></p>
		</div>
	</section>
	<section>
		<div class="con-goods">
			<div class="goods-header">
				<span>名片</span>
				<span class="">></span>
			</div>
			<!--商品内容-->
			<div class="goods-pro">
				<span></span>
				<span><img src="" alt="" /></span>
			    <div class="pro-info">
			    	<p>名片制作 透明名片 高档仿金属
			    		防水名片制作</p>
			    	<p class="proxilie"><span>系列 : PVC透明名片</span> <span>规格 : 200张</span></p>
			    	<p class="price"><span class="now">fdas</span><span class="old">432</span> <strong>×</strong>
			    		<strong class="num">1</strong></p>
			    </div>
			</div>
			<div class="prozong clearfix">
			    <span class="a">订单总价</span>
			    <span class="zong a">￥312</span>
			</div>
			<div class="yifu">
			    <span class="a">已付款</span>
			    <span class="pay">￥3232</span>
			</div>			    
		</div>		
	</section>
	<section>
       	<div class="lian">
       		<a href=""><img src="{{asset('images/member/lian1.png')}}" alt="" /></a>
       		<a href=""><img src="{{asset('images/member/lian2.png')}}" alt="" /></a>
       	</div>
	</section>
	<div class="kuang"></div>
	<div id="warn">
		<span>已经为您提醒商家尽快发货...</span>
	</div>
	<!--进入详情页面的三个状态  待付款  待发货  待确认  -->
	<div class="queren" style="display: none;">
	<button class="true">确认收货</button>
	</div>
	<div class="daifu"style="display: none;">
		<button class="payl true">付款</button>
		<button class="del true">取消</button>
	</div>
	<div class="daifa" >
	    <button class="warn true">提醒发货</button>
	    <button class="fahuo true">确认发货</button>
	</div>
<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/member/proinfo1.js')}}"></script>	
@yield('js')
</body>
</html>
<script>
	$(".warn").click(function(){
		$(".kuang").show();
		$("#warn").show();
		setTimeout(function(){
			$(".kuang").hide();
			$("#warn").hide();
		},2000)
	})
</script>
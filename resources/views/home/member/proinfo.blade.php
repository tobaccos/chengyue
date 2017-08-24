<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
			<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>订单详情</title>

		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/home/member/proinfo.css')}}" />
		@yield('css')

	</head>
	<body>
		<div class="header">
			<span class="left back">
				<img class="imgleft" src="{{asset('images/base/back.png')}}">
			</span>
			<span id="cent">订单详情</span>
		</div>
		<section>
			<!--三种状态-->
			<!--等待买家付款-->
			@if($data -> order_status == 0)
			<div class="time" >

				<div class="t-left">
					<p>
						等待买家付款
					</p>
					<p class="times">
						<input type="hidden" class="h-time" value="{{ $data->addtime }}"/>
						剩<span class="t-d">6</span>天<span class="t-h">24</span><span>时</span>自动关闭
					</p>
				</div>
				<div class="t-right">
					<img src="{{asset('images/member/time.png')}}" alt="" />
				</div>

				<!--<div class="time">
				<span id="t_d">00天</span>
				<span id="t_h">00时</span>
				<span id="t_m">00分</span>
				<span id="t_s">00秒</span>
				</div>
				</div>-->
				<!--买家已付款-->
				@elseif($data-> order_status == 1)
				<div class="time">
					
					<div class="t-left">
						<p>
							买家已付款
						</p>
						<p class="times">
							<input type="hidden" class="h-time" value="{{ $data->addtime }}"/>
							剩<span class="t-d">6</span>天<span class="t-h">24</span><span>时</span>自动确认
						</p>
					</div>
					<div class="t-right">
						<img src="{{asset('images/member/yifahuo.png')}}" alt="" />
					</div>
				</div>
				@elseif($data -> order_status == 3)
				<!--卖家已发货-->
				<input type="hidden" name="id" id="id" value="{{ $data->order_sn }}" />
				<input type="hidden" class="h-time" value="{{ $data->addtime }}"/>
				<div class="time">
					<div class="t-left">
						<p>
							卖家已发货
						</p>
						<p class="times">
							剩<span class="t-d">6</span>天<span class="t-h">24</span><span>时</span>自动确认
						</p>
					</div>
					<div class="t-right">
						<img src="{{asset('images/member/yifahuo.png')}}" alt="" />
					</div>
				</div>
				@endif
		</section>
		@if($address)
		<section>
			<div class="s-info">
				<img src="{{asset('images/member/jf.png')}}" alt="" />
				<p>
					<span>收货人:</span><span>{{$address->name}}</span><strong class="tel">{{$address->phone}}</strong>
				</p>
				<p>
					<span>收货地址：{{$address->address1}}{{$address->address2}}{{$address->address3}}{{$address->address4}}{{$address->address5}}{{$address->address_details}}</span>
				</p>
			</div>
		</section>
		@endif
		<section>
			<div class="con-goods">
				<div class="goods-header">
					<span>{{ $data -> tname }}</span>
					<span class="fuhap"></span>
				</div>
				<!--商品内容-->
				<div class="goods-pro">
					<span></span>
					<span>
					
					<img src="{{ url('uploads/product') }}/{{ $data -> thumbing}}" alt="" />
					</span>
					<div class="pro-info">
						<p>
							{{ $data-> pname }}
						</p>
						<p class="proxilie">
							<span>系列 : {{ $data -> tname }}</span><span></span>
						</p>
						<p class="proxilie">
							<span>规格: {{ $data -> tname }}</span><span></span>
						</p>
						<p class="price">
							<span class="now">￥{{$data->pro_price}}</span><span class="old">
							
						</p>
					</div>
				</div>
				<div class="prozong clearfix">
					<span class="a">订单总价</span>
					<span class="zong a">￥{{$data->pro_price}}</span>
				</div>
				<div class="yifu">
					<span class="a">已付款</span>
					<span class="pay">￥{{$data->pay_amount}}</span>
				</div>
			</div>
		</section>
		<section>
			<div class="lian">
				
					<img src="{{asset('images/member/lian1.png')}}" class="qqChat" />
				
			
					<img src="{{asset('images/member/lian2.png')}}" class="qqChat" alt="" />
				
			</div>
		</section>
		<div class="kuang"></div>
		<div id="warn">
			<span>已经为您提醒商家尽快发货...</span>
		</div>
		<!--进入详情页面的三个状态  待付款  待发货  待确认  -->
        
		@if($data -> order_status == 3)
		<div class="queren">
			<button class="true fahuo">
			确认收货
			</button>
		</div>
		@elseif($data -> order_status == 0)
		<!--<div class="daifu"style="display: none;">
			<button class="payl true">
			付款
			</button>
			<button class="del true">
			取消
			</button>
		</div>-->
		@elseif($data -> order_status == 1 || $data -> order_status == 2)
		<div class="daifa" >
			<button class="warn true">
			提醒发货
			</button>
			<!--<button class="fahuo true">
			确认收货
			</button>-->
		</div>
		@endif
		{{--qq客服弹出框--}}
		<div class="kuang"></div>
			<div class="qq">
				<div class="q-header">
					<img src="{{asset('images/base/kefu2.png')}}" alt="" />
			   </div>
			   <ul class="qqChoose">
			   	<li>
					<p><img src="{{asset('images/base/qq1.png')}}" alt="" /></p>
					<p class="kefu">客服小雅</p>
				</li>
				<li>
					<p><img src="{{asset('images/base/qq2.png')}}" alt="" /></p>
					<p class="kefu">橙果1组</p>
				</li>
				<li>
					<p><img src="{{asset('images/base/qq1.png')}}" alt="" /></p>
					<p class="kefu">橙果2组</p>
				</li>
				<li>
					<p><img src="{{asset('images/base/qq2.png')}}" alt="" /></p>
					<p class="kefu">橙果3组</p>
				</li>
				<li>
					<p><img src="{{asset('images/base/qq1.png')}}" alt="" /></p>
					<p class="kefu">橙果4组</p>
				</li>
				<li>
					<p><img src="{{asset('images/base/qq2.png')}}" alt="" /></p>
					<p class="kefu">客服小美</p>
				</li>
				<li>
					<p><img src="{{asset('images/base/qq1.png')}}" alt="" /></p>
					<p class="kefu">客服小雅</p>
				</li>
				<li>
					<p><img src="{{asset('images/base/qq2.png')}}" alt="" /></p>
					<p class="kefu">客服小雅</p>
				</li>
			   </ul>
			   <div class="closes"><img src="{{asset('images/base/closes.png')}}" alt="" /></div>
		</div>
		<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
		<script src="{{asset('js/rem.js')}}"></script>
		<script src="{{asset('js/goback.js')}}"></script>		
		<script src="{{asset('js/member/proinfo.js')}}"></script>
		<script src="{{asset('js/home/base/baseSingle.js')}}"></script>
		@yield('js')
	</body>
</html>
<script>//	时间倒计时
    var time = ($(".h-time").val())*1000+604800000; 
    console.log(time)
	var NowTime = new Date();
	var t = time- NowTime.getTime();
	var d = Math.floor(t / 1000 / 60 / 60 / 24);
	var h = Math.floor(t / 1000 / 60 / 60 % 24);
//	var m = Math.floor(t / 1000 / 60 % 60);
//	var s = Math.floor(t / 1000 % 60);
    if(t<0){
    	$(".times").html("订单已结束,请确认收货")
    }
    $('.t-d').text(d);
    $('.t-h').text(h)


//setInterval(GetRTime, 1000);
var url = "{{ url('/home/member/confirm') }}";
var url1 = "{{ url('/home/member/orderList') }}"
$(".fahuo").click(function() {
   var id = $("#id").val();
$.ajax({
	url: url,
	dataType: "json",
	async: true,
	data:{id:id},
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},

	type: "post", //请求的方式
	success: function(req) {
		if(req == "200"){
			window.location.href = url1;
		}

	},
	error: function() {} //请求出错的处理
});
})

$(".warn").click(function() {
		$(".kuang").show();
		$("#warn").show();
		setTimeout(function(){
			$(".kuang").hide();
			$("#warn").hide();
		},1500)

})
</script>
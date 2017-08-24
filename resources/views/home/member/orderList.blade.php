<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta name="_token" content="{{ csrf_token() }}"/>
		<title>我的订单</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/home/member/orderList.css')}}" />
		<style>
			
		</style>
		@yield('css')
	</head>
	<body>
		<div class="header">
			<span class="left">
				<a href="{{ url('/home/member/myInfo') }}">
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</a>
			</span>
			<span id="cent">我的订单</span>

		</div>
		<div class="hnav">
			<ul>
				<a href="{{ url('/home/member/orderList') }}" >
					<li class="hnavlist"id="li4">
						全部
					</li>
				</a>
				<a href="{{ url('/home/member/orderList?id=0') }}">
					<li class="hnavlist" id="li0">
						待付款
					</li>
				</a>
				<a href="{{ url('/home/member/orderList?id=1') }}">
					<li class="hnavlist" id="li1">
						待发货
					</li>
				</a>
				<a href="{{ url('/home/member/orderList?id=2') }}">
					<li class="hnavlist" id="li2">
						待收货
					</li>
				</a>
				<a href="{{ url('/home/member/orderList?id=3') }}">
					<li class="hnavlist" id="li3">
						待评价
					</li>
				</a>
			</ul>
		</div>

		<div class="content" id="all" style="display: none;">
			@if($res  && count($data) > 0)
			@foreach($data as $v)
			<input type="hidden" />
			<div class="goods">
				<div class="con-goods">
					<div class="goods-header">
						<span></span>
						<span></span>
						<span></span>
						<span class="state"> @if($v -> order_status == 0)
						未付款
						@elseif($v-> order_status == 1 || $v-> order_status == 2)
						待发货
						@elseif($v-> order_status == 3)
						待收货
						@elseif($v-> order_status == 4)
						已收货
						@endif </span>
					</div>
					<ul>
						<li>
							<a href="{{ url('/home/member/proinfo') }}/{{ $v -> order_sn }}">
								<input type="hidden" name="pro_id" value="{{ $v -> pro_id }}">
								<input type="hidden" name="order_status" value="{{ $v -> order_status }}">
								<div class="goods-pro">
									<span></span>
									<span>
									<img src="{{ asset('uploads/product') }}/{{ $v -> thumbing}}" alt="" />
									</span>
									<div class="pro-info">
										<p>
											{{ $v -> name}}
										</p>
										<p class="proxilie">
												<span>系列 : {{$v -> type_name}}</span><span></span>
										</p>
										<p class="price">
											<span class="now">￥{{ $v -> min }}</span><span class="old">￥{{ $v -> max }}</span>
											<strong class="num">{{ $v -> num}}</strong><strong>×</strong>
										</p>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
			@endforeach
			@else
			<a href="javascript:;">
				<img class="wu" src="{{url('images/member/zanwu.jpg')}}" style="width: 100%;"/>
			</a>
		@endif
		</div>
		<!--代付款页面-->
		<div class="content" id="daifu" style="display: none;">
			@if($res && isset($res['weifu']) && count($res['weifu']) > 0)
			@foreach($res['weifu'] as $v )
			<input type="hidden" />
			<div class="goods">
				<div class="con-goods">
					<div class="goods-header">
						<input type="hidden"  class="orderlist" value="{{ $v->order_sn }}" />
						<span class="choseItem">
						<img src="{{ asset('images/shopping/false.png')}}" alt="" />
						</span>
						<span></span>
						<span></span>
						<span class="state">商品未付款</span>
					</div>
					<ul class="con-info">
						<a href="{{ url('/home/member/proinfo') }}/{{ $v -> order_sn }}">
							<li>
								<!--商品内容-->
								<div class="goods-pro">
									<span class="chose"></span>
									<span><img src="{{ asset('uploads/product') }}/{{ $v -> thumbing}}" alt="" /></span>
									<div class="pro-info">
										<p>
											{{ $v -> name}}
										</p>
										<p class="proxilie">
											<span>系列 : {{ $v -> type_name }}</span><span></span>
										</p>
										<p class="price">
											<span class="now">￥{{ $v -> order_amount }}</span><span class="old">￥{{ $v -> max }}</span><strong class="num">{{ $v -> num}}</strong>
											<strong>×</strong>
											
										</p>
									</div>
								</div>
							</li>
						</a>
					</ul>
					<div class="pingjia">
						<input type="hidden" class="id" value="{{$v ->order_sn }}"/>
						<button class="del b">
							删除订单
						</button>
					</div>

				</div>

			</div>
			<!--结算-->
			<div class="banlance">
				<span id="a" class="all">
				<img src="{{ asset('images/shopping/false.png')}}" alt="" />
				</span>
				<label for="a">全选</label>
				<!--<span>合计 : </span>
				<span class="nowprice">￥130.00</span>-->
				<!--去结算-->
				<a href="javascript:;" class="ban-go">
					去结算
				</a>
			</div>
			@endforeach

			<form action="{{ url('home/shopping/member_to_order') }}" method="post" id="jiesuan">
				{{csrf_field()}}
				<input type="hidden" name="orders" id="data" value="data"/>
			</form>
			@else

			<a href="javascript:;">
				<img class="wu" src="{{asset('images/member/zanwu.jpg')}}" style="width: 100%;"/>
			</a>

		@endif
		</div>
		<!--代发货页面-->
		<div class="content" id="daifa" style="display: none;">
			@if($res && isset($res['weifa']) && count($res['weifa']) > 0)
			@foreach($res['weifa'] as $v )
			<input type="hidden" />
			<div class="goods">
				<div class="con-goods">
					<div class="goods-header">
						<span></span>
						<span></span>
						<span></span>
						<span class="state">买家已付款</span>
					</div>
					<ul>
						<a href="{{ url('/home/member/proinfo') }}/{{ $v -> order_sn }}">
							<li>
								<div class="goods-pro">
									<span></span>
									<span>
									<img src="{{ asset('uploads/product') }}/{{ $v -> thumbing}}" alt="" />
									</span>
									<div class="pro-info">
										<p>
											{{ $v -> name }}
										</p>
										<p class="proxilie">
											<span>系列 : {{ $v -> type_name }}</span><span></span>
										</p>
										<p class="price">
											<span class="now">￥{{ $v -> pay_amount }}</span><span class="old">￥{{ $v -> max }}</span>
											<strong class="num">{{ $v -> num}}</strong><strong>×</strong>
										</p>
									</div>
								</div>
							</li>
						</a>
					</ul>
				</div>
			</div>

			<!--合计-->
			<!--<div class="heji">
			<span>共<stong>1</stong>件商品</span>
			<span>合计：</span>
			<strong class="str">￥</strong><span>130.00</span>
			<span class="fare">(含运费￥0.00)</span>
			</div>-->
			@endforeach
				@else

			<a href="javascript:;">
				<img class="wu" src="{{url('images/member/zanwu.jpg')}}" style="width: 100%;"/>
			</a>

		@endif
		</div>


		<!--待评价-->

		<div class="content" id="daiping" style="display: none;">
			@if($res && isset($res['shou']) && count($res['shou']) > 0)
			@foreach($res['shou'] as $v )

			<div class="goods">
				<div class="con-goods">
					<div class="goods-header">
						<span></span>
						<span></span>
						<span></span>
						<span class="state">已确认收货</span>
					</div>
					<!--商品内容-->
					<ul>
						<a href="{{ url('/home/member/proinfo') }}/{{ $v -> order_sn }}">
							<li>
								<div class="goods-pro" >

									<span></span>
									<span>
									<img src="{{ asset('uploads/product') }}/{{ $v -> thumbing}}" alt="" />
									</span>
									<div class="pro-info">
										<p>
											{{ $v -> name }}
										</p>
										<p class="proxilie">
											<span>系列 : {{ $v -> type_name }}</span><span></span>
										</p>
										<p class="price">
											<span class="now">￥{{ $v -> pay_amount }}</span><span class="old">￥{{ $v -> max }}</span>
											<strong class="num">×{{ $v -> num}}</strong>
										</p>
									</div>
								</div>
							</li>
						</a>
					</ul>
				</div>
				<!--评价-->
			<div class="pingjia">
				<span>共
				<stong>
					1
				</stong>件商品</span>
				<span>合计：</span>
				<strong class="str">￥</strong><span>{{ $v -> pay_amount }}</span>

			</div>

			<!--评价-->
			<div class="pingjia">
				<input type="hidden" class="id" value="{{ $v -> order_sn }}"/>
				<button class="self1">
					删除订单
				</button>
				<form action="{{ url('/home/member/reviews') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" name="order_sn" value="{{ $v -> order_sn }}">
					<button type="submit" class="self">
					立即评价
					</button>
				</form>
			</div>
			</div>
			
			@endforeach
			@else
			<a href="javascript:;">
				<img class="wu" src="{{url('images/member/zanwu.jpg')}}" style="width: 100%;"/>
			</a>
			@endif
		</div>

		<!--待收货-->

		<div class="content" id="daishou" style="display: none;">
			@if( $res && isset($res['fahuo']) && count($res['fahuo']) > 0)
			@foreach($res['fahuo'] as $v)
			<input type="hidden" />
			<div class="goods">
				<div class="con-goods">
					<div class="goods-header">
						<span></span>
						<span></span>
						<span></span>
						<span class="state">买家待收货</span>
					</div>
					<ul>
						<a href="{{ url('/home/member/proinfo') }}/{{ $v -> order_sn }}">
							<li>
								<div class="goods-pro">
									<span></span>
									<span>
									<img src="{{ asset('uploads/product') }}/{{ $v -> thumbing}}" alt="" />
									</span>
									<div class="pro-info">
										<p>
											{{ $v -> name }}
										</p>
										<p class="proxilie">
											<span>系列 : {{ $v -> type_name }}</span><span></span>
										</p>
										<p class="price">
											<span class="now">￥{{ $v -> order_amount }}</span><span class="old">￥{{ $v -> max }}</span>
											<strong class="num">{{ $v -> num}}</strong><strong>×</strong>
										</p>
									</div>
								</div>
							</li>
						</a>
					</ul>
				</div>
				<div class="pingjia">

				<input type="hidden" name="" id="" value="{{ $v->order_sn }}" />
				<a href="javascript:;" class="true b">
					确认收货
				</a>
			</div>
			</div>
			
			@endforeach
			@else

			<a href="javascript:;">
				<img class="wu" src="{{url('images/member/zanwu.jpg')}}" style="width: 100%;"/>
			</a>

			@endif
		</div>
		<div class="kuang">
	</div>
	<div class="shadw">
       <p class="orderDel">您确定要删除该订单么删除订单将无法恢复?</p>
		<button class="sure" type="button">确定</button>
		<button class="quxiao" type="button">取消</button>
	</div>
		<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
		<script src="{{asset('js/rem.js')}}"></script>
		<script src="{{asset('js/goback.js')}}"></script>
		
		<script type="text/javascript">
function UrlSearch() {
	var name, value;
	var str = location.href; //取得整个地址栏
	var num = str.indexOf("?")
	str = str.substr(num + 1); //取得所有参数   stringvar.substr(start [, length ]
	var arr = str.split("&"); //各个参数放到数组里
	for(var i = 0; i < arr.length; i++) {
		num = arr[i].indexOf("=");
		if(num > 0) {
			name = arr[i].substring(0, num);
			value = arr[i].substr(num + 1);
			this[name] = value;
		}
	}
}
var Request = new UrlSearch(); //实例化
//   alert(Request.id);
if(Request.id == 0) {
	$("#li0").addClass("current").siblings().removeClass("current");
	$("#daifu").css('display', '');
} else if(Request.id == 1) {
	$("#li1").addClass("current").siblings().removeClass("current");
	$("#daifa").css('display', '');
} else if(Request.id == 2) {
	$("#li2").addClass("current").siblings().removeClass("current");
	$("#daishou").css('display', '');
} else if(Request.id == 3) {
	$("#li3").addClass("current").siblings().removeClass("current");
	$("#daiping").css('display', '');
} else {
	$("#li4").addClass("current").siblings().removeClass("current");
	$("#all").css('display', '');
}
//待评价订单删除
var urlAll = "{{ url('/home/member/order_del') }}";
//确认收货
var url = "{{ url('/home/member/confirm') }}";

//待付款订单删除
var url1 = "{{ url('/home/member/order_del') }}";

</script>
<script src="{{asset('js/member/orderList.js')}}"></script>
		@yield('js')

	</body>
</html>
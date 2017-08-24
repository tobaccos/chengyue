@extends('home.common.baseSingle')
@section('title')
购物车
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/shopping/shopCart.css')}}" />

@endsection
@section('content')
<!--购物车头部-->
<div class="header">
	<span class="back left">
                <img class="back imgleft" src="{{asset('images/base/back.png')}}">
	</span>
	<sapn id="cent">购物车</sapn>
</div>
<!--商品-->
<div class="goods">

	@if(isset($data))
	@if(empty($data))
		<a href="{{url('/')}}">
			<img class="wu" src="{{asset('images/shopping/shoppinga.png')}}" style="width: 100%;"/>
		</a>
	@endif
	@foreach($data as $key => $value)

  <div class="content">
	<div class="con-head">
		<span class="choseItem"><img src="{{ asset('images/shopping/false.png')}}" alt="" /></span>
		<span>{{$value[0]['pro_type']}}</span>
		<span>></span>
	</div>
	<div class="con-info">
		<ul>
	@foreach($value as $key => $val)		
			<li>
				@if(isset($val['attrNameVal']))
					<input type="hidden"  id="attrNameVal" value="{{$val['attrNameVal']}}" />
				@else
				@endif
				<input type="hidden"  id="price1" value="{{$val['price1']}}" />
				@if(isset($val['selfAttrObject']))
				<input type="hidden"  id="selfAttrObject" value="{{$val['selfAttrObject']}}" />
				@else
				@endif
				<input type="hidden"  id="proId" value="{{$val['proId']}}" />
				<input type="hidden"  id="type_umber" value="{{$val['typeNumber']}}" />
				<input type="hidden"  id="pro_name" value="{{$val['pro_name']}}" />
				<input type="hidden"  id="pro_type" value="{{$val['pro_type']}}" />
				<input type="hidden"  id="type_id" value="{{$val['type_id']}}" />
				<input type="hidden"  id="del_id" value="{{$val['del_id']}}" />
				<div class="chose"><img src="{{ asset('images/shopping/false.png')}}" alt="" /></div>
			    <p><img src="{{ asset(PRO_IMG_PATH.$val['pro_img'])}}" alt="" /></p>
			    <div class="info">
						<span>{{$val['pro_name']}}</span>
			    	<!--<span></span>-->
			    	<span></span>
			    	<h6>
			    		<strong class="reduce">-</strong>
			    		<input type="number" value="{{$val['num']}}"/>
			    		<strong class="add">+</strong>
			    		
			    	</h6>
			    </div>
			    <div class="price">
			    	<span class="price_origin"></span>
			    	
			    	<span class="price_real">￥{{$val['price1']}}</span>	
			    	<img class="del" data-id="{{$val['del_id']}}" src="{{ asset('images/shopping/cart.png')}}" alt="" />
			    	
			    </div>
			</li>
			@endforeach
		</ul>
	</div>
  </div>
  @endforeach
@else
			
		@if(session('info'))
			<div class="callout callout-success">
				<p>{{session('info')}}</p>
			</div>
		@endif
	@endif
</div>
<form id="jiesuan" action="{{url('home/shopping/cart_to_order')}}" method="post">
	
	<input type="hidden" name="data" id="data"  />
</form>
<div class="bottom">
	<span class="all"><img src="{{ asset('images/shopping/false.png')}}" alt="" /></span>
	<span>全选</span>
	<span>合计</span>
	<span class="total">￥0.00</span>
	<span ></span>
	<span class="balance">去结算<strong class="product_num">(0)</strong></span>
</div>
				
@endsection
@section('js')
<script type="text/javascript">
	var delurl="{{ url('/home/shopping/cart_del') }}";
	var buyurl="{{url('home/shopping/order')}}";

</script>
<script src="{{asset('js/goback.js')}}"></script>
<script src="{{ asset('js/home/shopping/shopCart.js')}}"></script>

@endsection
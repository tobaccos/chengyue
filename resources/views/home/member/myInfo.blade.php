@extends('home.common.baseSingle')
@section('title')
个人中心
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/home/member/myInfo/myInfo.css')}}" />
@endsection
@section('content')
<!--头部-->

<div class="header">
	<sapn>我的</sapn>
</div>
<section>
	<div class="state" >
		<a href="{{ url('/home/member/personal') }}">
		
			  <input type="hidden" name="img" id="img1" value="{{$data->pic}}" />
			 @if( $data->pic )
			 
				<img class="phot" src="{{ asset('uploads/user')}}/{{$data->pic}}" alt="" />
			 @else
				<img class="phot" src="{{ asset('images/login/loginlogo.png')}}" alt="" />
			 @endif			
		</a>
			<!--未登录状态-->
		@if($data)
		@if($data->state == 1)
	     <div class="statelogin">
	     	<span class="flogin">您还没有登录</span>
        	<a href="{{ url('/login') }}" class="clogin">点击登录</a>
	     </div>
	   
	     

				<!--代理商登录状态-->
         @elseif($data->dls_apply == 2)
			<div class="daivip">
				<div class="orinfo">
					<p>昵称 : <span class="nameInfo">{{$data->name}}</span> <span class="svip">代理商</span>
					<p>手机号 :
						@if($data->phone)
						<span class="phone">{{ $data->phone}}</span>
						@else
						<span class="phone">未绑定手机号</span>
						@endif
					</p>
					</p>
					<p>邮箱 :
						@if($data->email)
							<span class="vicar">{{ $data->email }}</span>
						@else
							<span class="vicar">未绑定邮箱</span>
						@endif
					</p>
				</div>

				<div class="photo">
					<img src=" {{ asset('home/code') }}/{{  $data -> code}}" alt="" />
				</div>
			</div>
		@elseif($data->dls_apply == 3)
		<!--申请未通过状态-->
			<div class="ordinary">
				<div class="orinfo">
					<p >昵称 : <span class="nameInfo">{{ $data->name }}</span></p>
					<p>手机号 :
						@if($data->phone)
						<span>{{ $data->phone}}</span>
						@else
						<span class="phone">未绑定手机号</span>
						@endif
					</p>
					<p>邮箱 :
						@if($data->email)
							<span class="vicar">{{ $data->email }}</span>
						@else
							<span class="vicar">未绑定邮箱</span>
						@endif
					</p>
				</div>
				
					<div class="photo">

						<p class="falsel">
							
							<img src="{{ asset('images/member/falses.png')}}" alt="" />
						</p>

					</div>
					<div class=" shadw1">
						<p>{{ $data->content }}</p>
						<button class="sure1" type="button">重新申请</button>
	 					<button class="quxiao1" type="button">取消申请</button>
					</div>
				</a>
			</div>
			 
       @elseif($data->dls_apply == 0)
			<!--普通登录状态-->
			<div class="ordinary">
				<div class="orinfo">
					<p >昵称 : <span class="nameInfo">{{ $data->name }}</span></p>
					<p>手机号 :
						@if($data->phone)
						<span>{{ $data->phone}}</span>
						@else
						<span class="phone" >未绑定手机号</span>
						@endif
					</p>
					<p>邮箱 :
						@if($data->email)
							<span class="vicar">{{ $data->email }}</span>
						@else
							<span class="vicar">未绑定邮箱</span>
						@endif
					</p>
				</div>
				<a href="{{ url('/home/member/areaApp') }}">
					<div class="photo">
						<p >
							<img src="{{ asset('images/member/VIP.png')}}" alt="" />
						</p>
					</div>
				</a>
			</div>
			@else
			  <!--代理商申请中-->
			  <div class="ordinary">
				<div class="orinfo">
					<p >昵称 : <span class="nameInfo">{{ $data->name }}</span></p>
					<p>手机号 :
						@if($data->phone)
						<span>{{ $data->phone}}</span>
						@else
						<span class="phone" >未绑定手机号</span>
						@endif
					</p>
					<p>邮箱 :
						@if($data->email)
							<span>{{ $data->email }}</span>
						@else
							<span class="vicar">未绑定邮箱</span>
						@endif
					</p>
				</div>
					<div class="photo">
						<p class="shenqing">
							<img src="{{ asset('images/member/VIP.png')}}" alt="" />
						</p>
					</div>
			</div>
	     @endif
@endif
	</div>
</section>
<!--全部订单-->
<section>
	<div class="infoOrder">
		<a href="{{ url('/home/member/orderList') }}">
		<div class="infoOrderAll">
			<img src="{{ asset('images/member/dingdan.png')}}" alt="" />
			<span class="a">全部订单</span>
		</div>
		</a>
		<div class="infoOrderCon">
			<ul>
				<li>
					<a href="{{ url('/home/member/orderList?id=0') }}">
					<img src="{{ asset('images/member/daifu.png')}}" alt="" />
					<strong id="paynum">{{$order['weifu']}}</strong>
					<span>待付款</span>
					</a>
				</li>
				<li>
					<a href="{{ url('/home/member/orderList?id=1') }}">
					<img src="{{ asset('images/member/daifa.png')}}" alt="" />
					<strong id="payfa">{{$order['weifa']}}</strong>
					<span>待发货</span>
					</a>
				</li>
				<li>
					<a href="{{ url('/home/member/orderList?id=2') }}">
					<img src="{{ asset('images/member/daishou.png')}}" alt="" />
					<strong id="paydai">{{$order['fahuo']}}</strong>
					<span>待收货</span>
					</a>
				</li>
				<li>
					<a href="{{ url('/home/member/orderList?id=3') }}">
					<img src="{{ asset('images/member/daipingjia.png')}}" alt="" />
					<strong id="payping">{{$order['shou']}}</strong>
					<span>待评价</span>
					</a>
				</li>
				<li class="qqChat">
					
					<img src="{{ asset('images/member/shouhou.png')}}" alt="" />
					<strong id="paydel"></strong>
					<span>售后/帮助</span>
					
				</li>
			</ul>
		</div>
	</div>
</section>
<!--分销管理-->
@if($data->dls_apply == 2)
<section>
	<div class="distribution">
		<div class="disControl">
			<img src="{{ asset('images/member/fenxiao.png')}}" alt="" />
			<span>分销管理</span>
		</div>
		<div class="dislei">
			<div class="disleiLeft">
				<a href="{{ url('/home/member/rebate') }}">
					<span><img src="{{ asset('images/member/fanli2.png')}}" alt="" /></span>
					<span>分销返利记录</span>
				</a>
			</div>
			<div class="disleiRight">
				<a href="{{ url('/home/member/cash') }}">
					<span><img src="{{ asset('images/member/fanli.png')}}" alt="" /></span>
					<span>余额提现</span>
				</a>
			</div>
		</div>
	</div>
</section>
@endif
<!--我的钱包-->
<section>
	<a href="{{ url('/home/member/price') }}">
	<div class="collect">
		<img src="{{ asset('images/member/price.png')}}" alt="" id="price" />
		<span class="a">我的钱包</span>
	</div>
	</a>
</section>
<!--我的收藏-->
<section>
	<a href="{{ url('/home/member/myfavorite') }}">
	<div class="collect">
		<img src="{{ asset('images/member/shoucang.png')}}" alt="" />
		<span class="a">我的收藏</span>
	</div>
	</a>
</section>
<section class="collect1">
	<a href="{{ url('/home/member/set') }}">
	<div class="mcontrol">
		<img src="{{ asset('images/member/shezhi.png')}}" alt="" />
		<span class="a">设置</span>
	</div>
	</a>
</section>
<div class="kuang">	
</div>
<div class="shadw">
       <div class="head">
       	请输入正确邮箱已确保后期找回密码
       </div>
	   <form action="/home/member/email" method="post">
		   	{{csrf_field()}}
		   	<input type="email" name="email" placeholder="请输入正确邮箱" id="email">
		   <button class="sure" type="submit">确定</button>
		   <button class="quxiao" type="button">取消</button>
	   </form>		
</div>
<div class="shadw2">
       <div class="head">
       	请输入正确手机号
       </div>
	   <form action="/home/member/phone" method="post">
		   	{{csrf_field()}}
		   	<input type="number" name="phone" placeholder="请输入正确手机号" id="phone" oninput="if(value.length>11)value=value.slice(0,11)">
		   <button class="sure" type="submit">确定</button>
		   <button class="quxiao" type="button">取消</button>
	   </form>
		
</div>
<div class="now">
	<span>您已经申请，正在审核中...</span>
</div>

@endsection
@section('js')
<script src="{{ asset('js/member/myInfo.js')}}"></script>
<script>
// 邮箱绑定
//  $(".vicar").click(function(){
//      $(".shadw").show();
//      $(".kuang").show();
//      $(".sure").click(function(){
//      })
//      $(".quxiao").click(function(){
//          $(".shadw").hide();
//          $(".kuang").hide();
//      })
//  })
//代理商未通过状态
    $(".falsel").click(function(){
    	var url = ""
    	$(".shadw1").show();
        $(".kuang").show();
        $(".sure1").click(function(){
        	window.location.href = "{{ url('/home/member/areaApp') }}";
        })
         $(".quxiao1").click(function(){
            $(".shadw1").hide();
            $(".kuang").hide();
        })
    })
 //手机号绑定
//$(".phone").click(function(){
//      $(".shadw2").show();
//      $(".kuang").show();
//      $(".sure").click(function(){
//      })
//      $(".quxiao").click(function(){
//          $(".shadw2").hide();
//          $(".kuang").hide();
//      })
//  })
</script>
@endsection
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>充值记录查询</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/rebate/rebate.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('home/member/price')}}">
				<span class="left">
				
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>
				<span class="title">充值记录查询</span>
			</div>
		</div>
		<div class="">
			<div class="wraper bg_white">
				<div class="info bg_white margin_top">
					<div class="common">
						<!--<form class="form1" action="{{ url('home/member/recharge')}}" method="post">-->
							<!--{{ csrf_field() }}-->
							<!--<input class="date_picker" type="text" id="demo1" name="user"  value="" />-->
							<input  type="text" onfocus="(this.type='date')" id="date1" name="ltime" placeholder="起始时间" >

							<span class="spa">~</span>
							<!--<input class="date_picker" type="text" id="demo2" name="user"  value="" />-->
							<input  type="text" onfocus="(this.type='date')" id="date2"  name="ftime" placeholder="结束时间">

							<img class="imglogo1 img2" src="{{asset('images/member/search.png')}}" />

						<!--</form>-->
					</div>
					<div class="common1">
						<!--<span>历史充值记录：</span>-->
						<!--span>{{$totalMoney->money}} </span>-->
					</div>
					<div class="common1">
						<table>
							<thead>
							<tr>
								<th>用户名</th>
								<th>充值时间</th>
								<th>金额</th>
							</tr>
							</thead>
							<tbody>
							@if(empty($data))
		                                           暂无数据
							@else						
							@foreach($data as $value)
								<tr>
									<input type="hidden" class="del" value="{{$value->id}}" />

									<td class="td">{{$value->name}}</td>
									<td><?php echo date("Y-m-d" ,$value-> created_at) ?></td>
									<td class="pos td">{{$value->money}}
										<!--<img src="{{asset('images/base/close.png')}}"/></td>-->
								</tr>
							@endforeach
							@endif	
							</tbody>
						</table>
					</div>
					
					<!--<div class="common2">
										<span class="total">总额：￥{{ $data->
										totalMoney }}</span>
					</div>-->
					
					
				     </div>
			    </div>
		    </div>
		<!--		<div class="footer">
		<a href="#javascript:;">退出当前账户</a>
		</div>-->
{{--右下角的返回顶部--}}
<a class="circle">
	<img src="{{asset('images/base/top.png')}}" />
</a>
	</body>
    <!--查询接口-->
	<script>
		var url = "{{url('home/member/rechargeDel')}}";
	    var url1 =  "{{ url('home/member/recharge')}}"
	</script>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/member/recharge.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	

</html>
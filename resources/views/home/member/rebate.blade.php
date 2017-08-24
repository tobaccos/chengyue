<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>分销返利记录</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/rebate/rebate.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<span class="left back">
				
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				<span class="title">分销返利记录</span>
			</div>
		</div>
		<div class="">
			<div class="wraper bg_white">
				<div class="info bg_white margin_top">
					
					<div class="common">
							<!--<input class="date_picker" type="text" id="demo1" name="user"  value="" />-->
							<input type="text" onfocus="(this.type='date')" id="date1" name="ltime" placeholder="起始时间" >

							<span class="spa">~</span>
							<!--<input class="date_picker" type="text" id="demo2" name="user"  value="" />-->
							<input type="text" onfocus="(this.type='date')" id="date2"  name="ftime" placeholder="结束时间">

							<img class="imglogo1 img2" src="{{asset('images/member/search.png')}}" />

						
					</div>
					<div class="common1">
						<!--<span>历史返利总额：</span>
						<span>{{$totalMoney->money}} </span>-->
					</div>
					<div class="common1">
						<table>
							<thead>
								<tr>
									<th>用户名</th>
									<th>返利时间</th>
									<th>金额</th>
								</tr>
							</thead>
							<tbody>
							@if(empty($data))
		                                        暂无数据
							@endif
								@foreach($data as $value)
								<tr>

									<input type="hidden" class="del" value="{{$value->id}}" />

									<td class="td">{{$value->name}}</td>
									<td><?php echo date("Y-m-d" ,$value-> created_at) ?></td>
									<td class="pos td">{{$value->money}}
										<img src="{{asset('images/base/close.png')}}"/></td>
										</tr>
										@endforeach

										</tbody>
										</table>
										</div>
										
					
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
	<script>
		var url = "{{url('home/member/rebateDel')}}";
		var url1 =  "{{ url('home/member/rebate')}}"
	</script>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/member/recharge.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	

</html>
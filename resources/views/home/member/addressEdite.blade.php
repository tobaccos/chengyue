<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>编辑收货地址</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/addressEdite/addressEdite.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{url('/home/member/address')}}">
				<span class="left ">
				<img class="imgleft" src="{{asset('images/base/back.png')}}">
				 </span>
				 </a>
				<span class="title">编辑收货地址</span>
			</div>
		</div>
		<div class="content">
			<div class="wraper bg_white">

					{{csrf_field()}}
					<div class="info bg_white margin_top">
						<div class="common ">
							<span>收货人:</span>
							<input type="text" name="name" id="user" maxlength="4" value="{{$data->name}}" pattern=/^[\u4e00-\u9fa5]{1,}$/ required />

						</div>
						<div class="common">
							<span>手机号:</span>
							<input type="tel" name="phone" id="tel"maxlength="11" value="{{$data->phone}}" required />
						</div>
						<div class="common common2">
							<select class="province"></select>
							<select class="city"></select>
							<select class="district"></select>
						</div>
						<div class="common3">
							<div class="common">
							<span>详细地址:</span>
							</div>
							<input name="id" type="hidden" value="{{$data->id}}" placeholder="请输入详细地址"/>
							<textarea type="text" name="detail" id="detail" required>{{$data->address_details	}}</textarea>
						</div>

					</div>

				<div class="ok">
						完成
				</div>
				<!--		<div class="footer">
				<a href="#javascript:;">退出当前账户</a>
				</div>-->

	</body>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/data.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>


	<script>

//		三级联动
		function options(data) {
	var options;
	for(var i in data) {
		options += '<option value=' + i + '>' + data[i] + '</option>'
	}
	return options
}
//	生成省
$(".province").html(options(datas[86]));
var proindex = $(".province").val();
$('.city').html(options(datas[proindex]));
var cityindex = $('.city').val();
$('.district').html(options(datas[cityindex]))

//生成相应市

$('.province').change(function() {
	var index = $(this).val();
	console.log(index)
	$('.city').html(options(datas[index]));
	var index2 = $('.city').val();
//      console.log(index);
        $('.district').html(options(datas[index2]))
})
//生成相应的区
$('.city').change(function() {
	console.log(111);
	var index = $(this).val();
	console.log(index)
	$('.district').html(options(datas[index]))

})



//发送数据的地址

var url="{{url('/home/member/addressUpdate')}}";

</script>
	<script src="{{asset('js/member/addressEdite.js')}}"></script>
</html>
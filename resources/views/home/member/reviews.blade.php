<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>商品评价</title>
		<style type="text/css"></style>

		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/home/member/reviews.css')}}" />
		@yield('css')

	</head>
	<body>
		<form action="{{ url('/home/member/proReviews') }}" method="post" id="myform" enctype="multipart/form-data">
			{{csrf_field()}}
			<input type="hidden" name="order_id" value="{{ $data -> id }}">
			<input type="hidden" name="pro_id" value="{{ $data -> pro_id }}">
			<div class="header">
				<a href="{{ url('/home/member/myInfo') }}" class="left">
				<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</a>
				<span>商品评价</span>
			</div>
			<div class="goods-pro">
				<span></span>
				<span>
				<img src="{{asset(PRO_IMG_PATH.$data -> thumbnailname )}}" alt="" />
				</span>
				<div class="pro-info">
					<p>
						{{ $data -> name }}
					</p>
					<p class="proxilie">
						<span>系列 : {{$data -> type_name}}</span>
						{{--<span>规格 : 200张</span>--}}
					</p>
					<p class="price">
						<span class="now">￥{{$data -> pay_amount}}</span>
						{{--<span class="old">￥150.00</span>--}}
					</p>
					<p class="pro-miao">
						<span class="a">描述相符</span><span></span>
					</p>
					<ul>
						<li>
							☆
						</li>
						<li>
							☆
						</li>
						<li>
							☆
						</li>
						<li>
							☆
						</li>
						<li>
							☆
						</li>
					</ul>
				</div>
			</div>
			<div class="crite">
				<textarea name="content" rows="4" cols="53" placeholder="请输入评论">默认好评</textarea>
			</div>
			<!--上传文件-->
			<div class="upload">
				<ol>
					<li></li>
				</ol>
				<div class="img_div"></div>
				<a href="javascript:;" class="a-upload">
					<input type="file" name="myFile" id="myFile" multiple="multiple" />
					<img src="{{ asset('images/member/shangchuan.jpg')}}" alt="" />
				</a>
				<div class="shade" onclick="javascript:closeShade()">
					<div class="">
						<span class="text_span"> </span>
					</div>
				</div>

				<div class="shadeImg" onclick="javascript:closeShadeImg()">
					<div class="">
						<img class="showImg" src="">
					</div>
				</div>
			</div>
			<div class="footer">
				<button type="submit">
				确认发表
				</button>
			</div>
		</form>

<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/member/reviews.js')}}"></script>
		@yield('js')
	</body>
</html>
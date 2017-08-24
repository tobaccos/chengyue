<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>@yield('title')</title>

	<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/home/base/baseSingle.css')}}" />

	@yield('css')

</head>
<body>

@yield('content')

{{--底部导航--}}

<div class="bottomPart">
	{{--分割线--}}
	<div class="line">
	</div>
	<div class="footer">
		<ul class="footItem">
			<li class="itemList">
				<a href="{{ url('/')}}"><img src="{{asset('images/base/home1.png')}}"/></a>
			</li>

			<li class="itemList">
				<a href="{{url('home/product/proList/0')}}"><img src="{{asset('images/base/fenlei1.png')}}"/></a>
			</li>


			<li class="itemList">
				<a href="{{url('/home/shopping/shopCart')}}"><img src="{{asset('images/base/cart1.png')}}"/></a>
				<strong id="payNumber">{{ session('cartNumber') }}</strong>
			</li>


			<li class="itemList">
				<a href="{{url('/home/member/myInfo')}}"><img src="{{asset('images/base/me1.png')}}"/></a>
			</li>


			<li class="itemList" id="qq">

				<div class="qqChat">
					<img src="{{asset('images/base/message1.png')}}"/>
					{{--这里用js添加客服--}}
				</div>
			</li>
		</ul>
	</div>
</div>
{{--底部导航结束--}}
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
<script src="{{asset('js/home/base/baseSingle.js')}}"></script>

@yield('js')
<script>
    @if(isset($_GET['par']))
        $("a").each(function(i,item){
        console.log("ashjfjafa")
        var href = $(this).attr('href');
        if (typeof(href) == "string")
        {
            if(href.indexOf("par")<0)
            {
                $(this).attr("href", href + "?par=" + {{$_GET['par']}});
            }
        }
    });
			@endif
			{{--生成分享链接--}}
			@if(isset($userId) && empty($_GET['par']))
    var shareUrl =location.href + "?par=" + {{$userId}};   //当前地址栏的链接地址
    console.log("ashjfjafa",shareUrl)
			@else
    var shareUrl =location.href;   //当前地址栏的链接地址
	@endif
</script>
</body>
</html>
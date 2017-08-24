<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>

	<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/home/base/baseSingle.css')}}" />
	<link rel="stylesheet" href="{{ asset('css/home/base/baseBoth.css')}}" />

	@yield('css')

</head>
<body>

<!--顶部导航-->
<div class="headPart">
			<span class="logo">
			<a href="{{url('/')}}">
				<img src="{{asset('images/base/logo.png')}}"/>
			</a></span>
	<span class="menu">
			<img src="{{asset('images/base/menu.png')}}">
			</span>
	<form action="{{url('search')}}">

		<input onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" onpaste="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" oncontextmenu = "value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" class="search" name="k" placeholder="请输入关键字搜索" type="text" />
		@if(isset($_GET['par']))
			<input type="hidden" name="par" value="{{$_GET['par']}}">
		@endif
		<img class="search_btn" src="{{asset('images/base/search_btn.png')}}"/>
		<button class="searchBtn" type="submit" value="搜索"></button>
	</form>
	<div class="menu_show">
		<ul>
			<li>
				<a href="{{url('home/member/myInfo')}}">
					个人中心
				</a>
			</li>
			<li class="lineRight"></li>
			<li>
				<a href="{{url('home/index')}}">
					首页
				</a>
			</li>
			<li class="lineRight"></li>
			<li>
				<a href="{{url('home/product/proList')}}/0">
					产品
				</a>
			</li>
			<li class="lineRight"></li>
			<li>
				<a href="{{url('/home/product/recommend')}}">
					今日推荐
				</a>
			</li>
			<li class="lineRight"></li>
			<li>
				<a href="{{url('/home/product/timeLimit')}}">
					限时预购
				</a>
			</li>
			<li class="lineRight"></li>
			<li>
				<a href="{{url('/home/product/proActive')}}">
					活动专区
				</a>
			</li>
			<li class="lineRight"></li>
			<li>
				<a href="{{url('/home/shopping/shopCart')}}">
					购物车
				</a>
			</li>
			{{--<li class="xiala">--}}
			{{--<a href="#javscript:;"></a>--}}
			{{--</li>--}}
		</ul>
	</div>
</div>

<!--顶部导航结束-->

@yield('content')

{{--底部导航--}}
<div class="bottomPart">
	{{--分割线--}}
	<div class="line"></div>
	<div class="footer">
		<ul class="footItem">
			<li class="itemList">
				<a href="{{ url('/')}}"><img src="{{asset('images/base/home1.png')}}"/></a>
			</li>

			<li class="itemList">
				<a href="{{ url('/home/product/proList/0')}}"><img src="{{asset('images/base/fenlei1.png')}}"/></a>
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
{{--qq客服弹出框结束--}}
<a class="circle">
	<img src="{{asset('images/base/top.png')}}" />
</a>

<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/home/base/baseSingle.js')}}"></script>
<script src="{{asset('js/home/base/base.js')}}"></script>
{{--手机端调试时引入下面的文件--}}
{{--<script src="http://192.168.2.104:8023/target/target-script-min.js#anonymous"></script>--}}
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
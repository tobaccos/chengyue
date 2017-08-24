<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>活动专区</title>
	<meta name="_token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/product/proList.css') }}" rel="stylesheet">

</head>
<body>

{{--头部--}}
<div class="headPart" id="top">
    <a href="{{url('home/index')}}" class="return back"><img src="{{asset('images/base/return.png')}}"></a>
   	<input onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" onpaste="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" oncontextmenu = "value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" class="search" name="k"  type="text" />
    <span class="searchBtn"><img src="{{asset('images/base/search_btn.png')}}"></span>
</div>
<div class="orderBy">

	<ul class="orderItem">
		<li class="orderItemList" value="id">赠品</li>
		<li class="orderItemList" value="volume">热度</li>
		<li class="orderItemList" value="show_time">时间</li>
		<li class="orderItemList" value="collection">收藏</li>
	</ul>
</div>
{{--头部结束--}}
{{--列表开始--}}
<div class="proArea">
	<ul class="proItem">
		@if($para['count'] > 0)
			@foreach($data as $value)
			<li class="proItemList">
				<a class="proImg" href="{{url('home/product/proDetail')}}/{{$value->id}}/4">
					<img data-original="{{PRO_IMG_PATH.$value->thumbing}}" alt="" />
				</a>
				<a class="proName" href="javascript:;">{{$value->name}}</a>
				<span class="proPrice">￥{{$value->min}}</span>
			</li>
			@endforeach
				{{--{{ $data->links() }}--}}
				<div class="hasInBotm">亲，已经到底部了哦~~</div>
		@else
			<img class="nomore" src="{{asset('images/base/nomore.png')}}" style="width: 100%;"/>
		@endif
	</ul>

</div>


{{--列表结束--}}

{{--右下角的返回顶部--}}
<img class="listDif" src="{{asset('images/base/active.png')}}">
<a class="circle">
	<img src="{{asset('images/base/top.png')}}" />
</a>

<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/goback.js')}}"></script>
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


     var urlAll = "{{url('home/product/toproActive')}}";
     var url2 = "{{url('images/base/nomore.png')}}";
 </script>
<script src="{{asset('js/product/proActive.js')}}"></script>
<!--延时加载-->
    <script src="{{asset('js/jquery.lazyload.js?v=1.9.1')}}"></script>
    <script src="{{asset('js/lazyload.js')}}"></script>	
</body>
</html>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>限时预购</title>
	<meta name="_token" content="{{ csrf_token() }}"/>
	<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/home/product/proList.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/home/product/timeLimit.css') }}"/>
</head>
<body>

{{--头部--}}
<img class="listDif" src="{{asset('images/base/timeList.png')}}">
<div class="headPart" id="top">
	<a href="{{url('home/index')}}" class="return back">
		<img src="{{asset('images/base/return.png')}}">
	</a>
	<input onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" onpaste="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" oncontextmenu = "value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\ ]/g,'')" class="search" name="k" type="text" />
	<span class="searchBtn"><img src="{{asset('images/base/search_btn.png')}}"></span>
	    <ul id="keywords">
    	
    </ul>
</div>
<div class="orderBy">

	<ul class="orderItem">
		<li class="orderItemList" value="id">
			综合
		</li>
		<li class="orderItemList" value="volume">
			销量
		</li>
		<li class="orderItemList" value="show_time">
			时间
		</li>
		<li class="orderItemList" value="collection">
			收藏
		</li>
		<li class="orderItemList sortCheck">
			筛选
		</li>
	</ul>
		<div class="orderSelected"><!--<span>名片<img data-original="{{url("images/base/close1.png")}}" ></span>--></div>
	

</div>
{{--头部结束--}}

{{--筛选的弹框--}}
<div class="overLay"></div>
<div class="checkModel">
	<span class="checkTitle">类别</span>
	<ul class="sortItem">
<!--		<span class="textIN">类别</span><br/>-->
		@foreach($para['proType'] as $val)
		<li value="{{$val->id}}">{{$val->name}}</li>
		@endforeach
		<br /><span class="textIN">价钱区间（元）</span>
	<div class="inputArea">
		<input class="minPriceInput" type="number" placeholder="最低价">
			<div class="shortLine"></div>
		<input class="maxPriceInput" type="number" placeholder="最高价">
	</div>
	</ul>
	
	<span class="checkSure">确定</span>
</div>
{{--筛选的弹框结束--}}

{{--列表开始--}}
<div class="proArea">
	<ul class="proItem">
		@if($para['count'] > 0)
			@foreach($data as $value)
				<li class="proItemList">
				<!--<input type="hidden" name="" class="time-t" value="{{$value->name}}" />-->
					<a class="proImg" href="{{url('home/product/proDetail')}}/{{$value->id}}/3">
						<img data-original="{{PRO_IMG_PATH.$value->thumbing}}" alt="" />
					</a>
					<a class="proName" href="javascript:;">{{$value->name}}</a>
					<span class="proPrice">￥{{$value->min}}</span>
					<input type="hidden" value="{{ $value -> end_time}}" />
					@if($value -> end_time)
						<div class="time">
							<span class="t_d" style="float: left;">00天</span>
							<span class="t_h" style="float: left;">00时</span>
							<span class="t_m" style="float: left;">00分</span>

							<!--<span class="t_s">00秒</span>-->
						</div>
					@else

					@endif

				</li>
			@endforeach
			{{--{{ $data->links() }}--}}
				<div class="hasInBotm">亲，已经到底部了哦~~</div>
		@else

			<img class="nomore" src="{{asset('images/base/nomore.png')}}" style="width: 100%;"/>
		@endif
	</ul>

</div>
<input type="hidden" id="imgPath" value="{{ PRO_IMG_PATH }}">
{{--列表结束--}}

{{--右下角的返回顶部--}}
<a class="circle">
	<img src="{{asset('images/base/top.png')}}" alt="" />
</a>

<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
{{--<script src="{{asset('js/goback.js')}}"></script>--}}

<script>//时间戳转换部位标准时间

     //			分享所需，不要摘出去
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



    
    // 产品图片地址
    var imgPath = $('#imgPath').val();
 	var urlAll = "{{url('home/product/totimeLimit')}}";
	@if($para['count'] > 0)
    var url1 = "{{url('home / product / proDetail ')}}/{{$value->id}}/3";
    @endif
    var url2 = "{{asset('images/base/nomore.png')}}";
    var urlClose="{{asset('images/base/close1.png')}}";


   
    // 产品图片地址
 

   </script>
<script src="{{asset('js/product/timeLimit.js')}}"></script>
<!--延时加载-->
    <script src="{{asset('js/jquery.lazyload.js?v=1.9.1')}}"></script>
    <script src="{{asset('js/lazyload.js')}}"></script>	
</body>
</html>
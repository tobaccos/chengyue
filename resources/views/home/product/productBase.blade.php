<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield('title')</title>

    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <link href="{{ asset('css/home/product/proList.css') }}" rel="stylesheet">
     @yield('css')
</head>
<body>

{{--头部--}}
<div class="headPart" id="top">
    <a href="{{url('home/index')}}" class="return back"><img src="{{asset('images/base/return.png')}}"></a>
    <input class="search" type="text" />
    <span class="searchBtn">搜索</span>
</div>
{{--头部结束--}}
 @yield('content')

{{--右下角的返回顶部--}}
<a class="circle" href="#top">
	<img src="{{asset('images/base/top.png')}}" />
</a>

<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
{{--<script src="{{asset('js/goback.js')}}"></script>--}}
<!--<script src="{{asset('js/product/proList.js')}}"></script>-->
 @yield('js')
</body>
</html>
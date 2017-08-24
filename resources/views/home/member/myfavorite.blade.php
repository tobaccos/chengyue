<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
          <meta name="_token" content="{{ csrf_token() }}"/>
    <title>我的收藏</title>
    
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home/member/myfavorite.css')}}" />
    @yield('css')
</head>
<body>
    <div class="header">
        <a href="{{ url('/home/member/myInfo') }}" class="left"><img class="imgleft" src="{{asset('images/base/back.png')}}"></a>
        <span id="cent">我的收藏</span>       
    </div>
        @if( count($data) >0 )

    <div class="content">
		@foreach($data as $v)

    	<div class="goods-pro">
    		<input type="hidden" name="id" value="{{ $v->id}}"/>
			<span class="choose"><img src="{{ asset('images/shopping/false.png')}}" alt="" /></span>
			<a href="{{ url('/home/product/proDetail') }}/{{ $v->pro_id }}/{{ $v->table_type }}">
			<i class="a-href"><img src="{{ url(PRO_IMG_PATH.$v->thumbing) }}" alt="" /></i>
			<div class="pro-info">
				<p>{{ $v -> name }}</p>
				<p class="proxilie"><span>系列 : {{ $v -> type_name }}</span> <span></span></p>
				<p class="price"><span class="now">￥{{ $v -> max }}</span><span class="old">￥{{ $v -> min }}</span></p>
				<a href="{{ url('/home/product/proList') }}/{{ $v->type_id }}"><button class="find">找相似</button></a>
				@if( $v->table_type ==1)
				<span class="type">此商品来自: 产品</span>
				@elseif($v->table_type ==2)
				<span class="type">此商品来自: 今日推荐</span>
				@elseif($v->table_type ==3)
				<span class="type">此商品来自: 限时预购</span>
				@elseif($v->table_type ==4)
				<span class="type">此商品来自: 活动产品</span>
				@endif
			</div>
			</a>
		</div>

		@endforeach
   </div>
   @else
    <div class="wus">
		<a href="{{ url('/') }}">
			<img src="{{ asset('images/member/collect.jpg')}}" style="width: 100%; alt="" />
		</a>
	</div>
	@endif
   <div class="bottom">
   	<p class="del">取消收藏</p>
   </div>   
<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/member/myfavorite.js')}}"></script>
    <script>
        var urlAll = "{{ url('/home/member/collect_del') }}";
    </script>
<script>

</script>
@yield('js')
</body>
</html>
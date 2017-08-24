@extends('home.common.baseBoth')
@section('title')
	首页
@endsection
@section('css')
	<link rel="stylesheet" href="{{ asset('css/swiper.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('css/home/index/index.css')}}" />
@endsection

@section('content')

	<div class="index_content">
		<!--广告位-->
		<div class="banner">
			{!!get_ad('index_banner1')!!}
		</div>
		<!--产品轮播-->
		<div class="proList_con">
			<!-- Swiper -->
			<div class="swiper_wraper">
				<div id="proList" class="swiper-container">
					<div class="swiper-wrapper">
						@if(isset($data['productType']))
							@foreach($data['productType'] as $val)
								<div class="swiper-slide swiper-p1">
									<ul>
										@foreach($val as $v)
											<li>
												<a href="{{url('home/product/proList')}}/{{$v->id}}">
													<div class="imgDiv">
														<img src="{{ PRO_CATE_IMG_PATH.$v->pic }}"/>
													</div>
													<span>{{$v->name}}</span>
												</a>
											</li>
										@endforeach
									</ul>
								</div>
							@endforeach
						@else
							暂无产品分类
						@endif
					</div>

				</div>
				<!-- Add Pagination -->
				<div id="page1" class="swiper-pagination"></div>
			</div>
		</div>
		<!--今日推荐-->
		<div class="index_recommend">
			
			<div class="recommond_title">

				<span> </span>
				<span>今日推荐</span>
				<span>  </span>
				<span class="more">
			<a href="{{url('home/product/recommend')}}">
				更多
			</a></span>
			</div>
			<div class="recommond_con">
				@if($data['productToday'])
					@foreach($data['productToday'] as $val)
						<div class="img_box">
							<a href="{{url('home/product/proDetail')}}/{{$val->id}}/2">
								<img src="{{get_pro_pic_first('recommend',$val->id)}}"/>

							</a>
						</div>
					@endforeach
				@endif
			</div>
		</div>

		<!--限时预购-->
		<div class="index_timeLimit">

			<div class="timeLimit_title">

				<span> </span>

				<span>限时预购</span>
				<span> </span>
				<span class="more">
			<a href="{{url('home/product/timeLimit')}}">
				更多
			</a></span>
			</div>
			<div class="timeLimit_con">
				<div class="timeLimit_item1">
					@if(isset($data['productBuy'][0]->thumbing))
						<div>
							<a href="{{url('home/product/proDetail')}}/{{$data['productBuy'][0]->id}}/3">
								<img data-original="{{get_pro_pic_first('pre_buy',$data['productBuy'][0]->id)}}"/>
								<img class="jinrihaohuo" src="{{asset('images/base/haohuo.png')}}"/>
							</a>
						</div>
					@endif
					@if(isset($data['productBuy'][1]->thumbing))
						<div>
							<a href="{{url('home/product/proDetail')}}/{{$data['productBuy'][1]->id}}/3">
								<img data-original="{{get_pro_pic_first('pre_buy',$data['productBuy'][1]->id)}}"/>
							</a>
						</div>
					@endif
				</div>
				<div class="timeLimit_item2">
					@for($i = 2; $i < 5; $i++)
						@if(isset($data['productBuy'][$i]->thumbing))
							<div>
								<a href="{{url('home/product/proDetail')}}/{{$data['productBuy'][$i]->id}}/3">
									<img data-original="{{PRO_IMG_PATH.$data['productBuy'][$i]->thumbing}}"/>
								</a>
							</div>
						@endif
					@endfor

				</div>

			</div>
		</div>
		<!--活动专区-->
		<div class="index_activity">
			<div class="activity_title">
				<span></span>

				<span>活动专区</span>
				<span></span>

				<a class="more" href="{{url('home/product/proActive')}}">
					更多
				</a>

			</div>
			<div class="activity_bg">
				{{--广告位--}}
				{!!get_ad('index_banner2')!!}
			</div>

			<div class="activity_imgbox">
				<ul>
					@foreach($data['productAcivity'] as $values)
						<li>
							<a href="{{url('home/product/proDetail')}}/{{$values->id}}/4">
								<img data-original="{{get_pro_pic_first('activity',$values->id)}}"/>
							</a>
						</li>
					@endforeach
				</ul>
			</div>

		</div>
		<!--产品列表-->
		<div class="index_product">
			@if(isset($data['product']))
				@for($i = 0;$i < count($data['product']); $i++)

					<div class="index_productList">
						<div class="product_title">
							<a class="product_btn" href="javascript:;">
								{{$data['product'][$i]['type_name']}}
							</a>
						</div>
						<div class="product_con">

							<div class="product_imgbox">
								@if(isset($data['product'][$i]['alias']))
									{{--@if($ad[$i]['alias'] != 'index_banner1' && $ad[$i]['alias'] == 'index_banner'.($i+3))--}}
											{!!get_ad($data['product'][$i]['alias'])!!}

									{{--@endif--}}

								@endif
								{{--<a href="{{url('home/product/proDetail')}}/{{ $data['product'][$i][0]['id'] }}/1">--}}


									{{--{{ var_dump('index_banner'.($i+3)) }}--}}
{{--									{!!get_ad('index_banner')!!}--}}


								{{--<a href="{{url('home/product/proList')}}/{{$data['product'][$i]['type_id']}}">--}}
									{{--@if(isset($data['product'][$i][0]['thumbing']))--}}

{{--										<img data-original="{{PRO_IMG_PATH.$data['product'][$i][0]['thumbing']}}"/>--}}
									{{--@endif--}}
								{{--</a>--}}

								<a class="product_btn" href="{{url('home/product/proList')}}/{{$data['product'][$i]['type_id']}}">
									进入专区
								</a>
							</div>
							<div class="product_imgbox">
								<div>

									@if(isset($data['product'][$i][0]['thumbing']))
										<a href="{{url('home/product/proDetail')}}/{{ $data['product'][$i][0]['id'] }}/1">
											<img data-original="{{get_pro_pic_first('product',$data['product'][$i][0]['id'])}}"/>
										</a>
									@endif

								</div>
								<div>

									@if(isset($data['product'][$i][1]['thumbing']))
										<a href="{{url('home/product/proDetail')}}/{{ $data['product'][$i][1]['id'] }}/1">
											<img data-original="{{get_pro_pic_first('product',$data['product'][$i][1]['id'])}}"/>
										</a>
									@endif

								</div>
							</div>

							<div class="product_imgbox">
								<div>

									@if(isset($data['product'][$i][2]['thumbing']))
										<a href="{{url('home/product/proDetail')}}/{{ $data['product'][$i][2]['id'] }}/1">
											<img data-original="{{get_pro_pic_first('product',$data['product'][$i][2]['id'])}}"/>
										</a>
									@endif

								</div>
								<div>

									@if(isset($data['product'][$i][3]['thumbing']))
										<a href="{{url('home/product/proDetail')}}/{{ $data['product'][$i][3]['id'] }}/1">
											<img data-original="{{get_pro_pic_first('product',$data['product'][$i][3]['id'])}}"/>
										</a>
									@endif

								</div>
							</div>
						</div>
					</div>
				@endfor
			@else
										<img class="nomore" src="{{asset('images/base/nomore.png')}}" style="width:3rem;"/>

			@endif
		</div>






		<!--合作商家-->
		<div id="couple" class="swiper-container newHeight">
			<div class="swiper-wrapper">
				@foreach($partner as $v)
					<div class="swiper-slide">
						<a href="">
							<img data-original="{{url('/uploads/product/cate')}}/{{$v -> pic}}">
						</a>
					</div>
				@endforeach
			</div>

		</div>
	</div>

	<div class="hasInBotm">亲，已经到底部了哦~~</div>
@endsection

@section('js')
<!--延时加载-->
    <script src="{{asset('js/jquery.lazyload.js?v=1.9.1')}}"></script>
    <script src="{{asset('js/lazyload.js')}}"></script>	
	<script src="{{asset('js/swiper.min.js')}}"></script>
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


        var swiper1 = new Swiper('#proList', {
                pagination: '#page1',
                paginationClickable: true
            });

        var swiper2 = new Swiper('#couple', {
            pagination: '#page2',
            slidesPerView: 4,
            paginationClickable: true,
            spaceBetween: 30,
            loop: true,
            autoplay: 2000,
            //      autoplayDisableOnInteraction: false

        });</script>
@endsection

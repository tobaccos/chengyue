<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>管理收货地址</title>
		<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home/member/address/address.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="header">
			<div class="wraper">
				<a href="{{ url('/home/member/set') }}">
				<span class="left">								
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				</a>
				<span class="title">管理收货地址</span>
				<span class="right"><a href="{{ url('/home/member/addressAdd') }}">添加</a></span>
			</div>
		</div>
		<div class="content">

			@if(count($data) > 0)
			@foreach ($data as $value)
			<input type="hidden" id="aid" value="{{$value->id}}">
			<div class="addressList  bg_white">
				
				<div class="wraper">
					<div class="userDate">
					<span>收货人:</span>
					<span>{{$value->name}}</span>
					<span class="phone">{{$value->phone}}</span>
				</div>

				<div class="addressItem">
					{{$value->address1}}{{$value->address2}}{{$value->address3}}{{$value->address4}}{{$value->address5}}{{$value->address_details}}
					
				
				</div>
				<div class="default">
					<span>
						@if ($value->is_default == 1)
        <img class="defaultImg" data-id="{{$value ->id}}" src="{{ asset('images/shopping/true.png')}}"/>
        @else
        <img class="defaultImg" data-id="{{$value ->id}}" src="{{ asset('images/shopping/false.png')}}"/>
        
    @endif
						
						</span>
				<span>设为默认</span>
				<span class="right">
					<span><img class="imgleft" src="{{asset('images/shopping/edite.png')}}"/>
											<input type="hidden" id="aid" value="{{$value->id}}">

					</span>
				<span>编辑</span>
				<span><img class="delimg" src="{{asset('images/shopping/del.png')}}"/>
					<input type="hidden" id="aid" value="{{$value->id}}">
				</span>
				<span>删除</span>
				</span>
				
				</div>
				</div>
				
			</div>
			@endforeach
			@else
				<a href="{{ url('/home/member/addressAdd') }}">
					<img src="{{ asset('images/member/dizhi.png')}}" style="width: 100%; alt="" />
				</a>
			@endif
			<form action='' method="post">
				{{csrf_field()}}
				<input type="hidden" name="id" id="id" value=""/>
			</form>

		</div>

		
	</body>
	<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
	<script src="{{asset('js/rem.js')}}"></script>
	<script src="{{asset('js/goback.js')}}"></script>
	
	<script type="text/javascript">
		var urldefault="{{url('/home/member/default')}}";
		var urledite="{{url('/home/member/address')}}";
		var urldel="{{url('/home/member/delete')}}";
	</script>
	<script src="{{asset('js/member/address.js')}}"></script>
	<script>

        $('.imgleft').click(function() {

            var uaddress_id = $(this).siblings('input').val();
			console.log(uaddress_id);
            $('#id').val(uaddress_id);
            $("form").attr("action","{{ url('home/member/addressEdite') }}")
            $('form').submit();

        });

	</script>
	
</html>
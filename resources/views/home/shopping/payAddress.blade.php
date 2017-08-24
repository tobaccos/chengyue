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
				<span class="left back">
				
					<img class="imgleft" src="{{asset('images/base/back.png')}}">
				</span>
				<span class="title">管理收货地址</span>
				<span class="right"><a href="{{ url('/home/shopping/paychange') }}">添加</a></span>
			</div>
		</div>
		<div class="content">
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
				<span>选择此地址</span>
				<span class="right">
					<!--<span><img class="imgleft" src="{{asset('images/shopping/edite.png')}}"/>
											<input type="hidden" id="aid" value="{{$value->id}}">

					</span>-->
				<!--<span>编辑</span>
				<span><img class="delimg" src="{{asset('images/shopping/del.png')}}"/>
					<input type="hidden" id="aid" value="{{$value->id}}">
				</span>
				<span>删除</span>
				</span>-->
				
				</div>
				</div>
				
			</div>
			@endforeach
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
		var burl= "{{ url('home/shopping/order') }}";
	</script>
	<script src="{{asset('js/home/shopping/payAddress.js')}}"></script>
	<script>

        $('.imgleft').click(function() {

            var uaddress_id = $(this).siblings('input').val();
			console.log(uaddress_id);
            $('#id').val(uaddress_id);
            $("form").attr("action","{{ url('home/member/address') }}")
            $('form').submit();

        });

	</script>
	
</html>
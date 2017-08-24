@extends('admin.common.base')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/mycss/common/alertwords.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/print.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.css') }}"  type="text/css" media="print"/>
<link rel="stylesheet" href="{{ asset('admin/mycss/order/logistic.css') }}" />


{{--弹出的上传样式--}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/mycss/order/uploadRequire.css') }}"/>
@endsection
@section('first_title','首页')
@section('second_title','客户需求')


@section('content')

    <a class="btn btn-xs btn-info backLast" href="{{url('admin/order/orderList')}}">返回</a>

@foreach($data as $v)
<div class="upImg1">
    <div class="preview1">
        <img class="image_1" src="{{ url('uploadRequire') }}/{{ $v['0'] }}">
    </div>
    <textarea class="imgDes1" rows="6" cols="16" name="require[]" placeholder="在此处输入您的需求描述哦..." disabled>{{ $v['1'] }}</textarea>
</div>
@endforeach

<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('common/layer/layer.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/goback.js')}}"></script>
<script src="{{asset('js/home/base/baseSingle.js')}}"></script>
<script src="{{asset('js/product/uploadRequire.js')}}"></script>

<script>
    var requireUrl = "{{url('uploadRequire')}}";

</script>



@endsection
@section('js')
<script src="{{ asset('admin/components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/jquery.jqprint-0.3.js') }}"></script>
<script src="{{ asset('admin/jquery-migrate-1.1.0.js') }}"></script>
<script src="{{ asset('admin/myjs/order/logistic.js') }}"></script>
<script>
var libUrl= "{{ url('admin/order/lib') }}";
//  $(function(){
//     //  console.log("print",$('#printArea').css('height'));
//     $('#logoImg').css("width",$('#printArea').css('width'));
//  })
</script>
 <script src="{{ asset('admin/jquery.number.js') }}"></script>


 @endsection

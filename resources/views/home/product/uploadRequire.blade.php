<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>需求上传</title>

    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">
    <link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">
    {{--弹出的上传样式--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home/product/uploadRequire.css') }}"/>
</head>
<body>

<div class="topArea" >
    <a href="javascript:;"><img class="back" src="{{asset('images/base/return.png')}}"></a>
    <span class="topTitle">如不能满足需求，请联系客服</span><img class="qqChat" src="{{asset('images/base/qqNo.png')}}">
</div>
{{--@if(session('info'))--}}
    {{--<div class="alert alert-info myalert">--}}
        {{--<button class="close" data-dismiss="alert">--}}
            {{--<i class="ace-icon fa fa-times "></i>--}}
        {{--</button>--}}
        {{--<i class="fa fa-hand-pointer-o "></i>&nbsp;&nbsp;温馨提示:--}}
        {{--<div class="alertwords">--}}
            {{--<p>{{session('info')}}</p>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endif--}}
<form id="uploadForm" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
        @if(isset($data))
        <div class="upImg1">
            <div class="preview1">
                <img class="image_1" src="{{ asset('uploads/temp') }}/{{ $data['0'] }}">
            </div>
            {{--这里加上accept可以直接限制打开手机的某些文件--}}
            <input type="file" class="uploadBtn_1" name="pic1" onchange="previewFile1()">
            <textarea class="imgDes1" rows="6" cols="16" name="require1" placeholder="在此处输入您的需求描述哦...">{{ $data['1'] }}</textarea>
        </div>
        @else
        <div class="upImg1">
            <div class="preview1">
                <img class="image_1" src="">
            </div>
            <input type="file" class="uploadBtn_1" name="pic1" onchange="previewFile1()">
            <textarea class="imgDes1" rows="6" cols="16" name="require1" placeholder="在此处输入您的需求描述哦..."></textarea>
        </div>
        @endif

        @if(isset($date))
        <div class="upImg2">
            <div class="preview2">
                <img class="image_2" src="{{ asset('uploads/temp') }}/{{ $date['0'] }}">
            </div>
            <input type="file" class="uploadBtn_2" name="pic2"  onchange="previewFile2()">
            <textarea class="imgDes2" rows="6" cols="16" name="require2" placeholder="在此处输入您的需求描述哦...">{{ $date['1'] }}</textarea>
        </div>
        @else
        <div class="upImg2">
            <div class="preview2">
                <img class="image_2" src="">
            </div>
            <input type="file" class="uploadBtn_2" name="pic2"  onchange="previewFile2()">
            <textarea class="imgDes2" rows="6" cols="16" name="require2" placeholder="在此处输入您的需求描述哦..."></textarea>
        </div>
        @endif

    <span class="noticeText">如果想换图片，点击图片就可以实现的哦~</span>
    <input type="hidden" name="id" value="{{ $id }}">
    <input type="hidden" name="number" value="{{ $number }}">
    <span class="iDo">确认上传</span>

</form>





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


<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('common/layer/layer.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/goback.js')}}"></script>
<script src="{{asset('js/home/base/baseSingle.js')}}"></script>
<script src="{{asset('js/product/uploadRequire.js')}}"></script>

<script>
    var requireUrl = "{{url('uploadRequire')}}";
    var upRequireUrl = "{{url('home/product/uploadRequire')}}";

</script>



</body>
</html>
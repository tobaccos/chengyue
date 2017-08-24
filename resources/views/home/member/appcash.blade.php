<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>申请提现冻结金</title>
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">
    <link href="{{ asset('css/home/member/cash/cash.css') }}" rel="stylesheet">
</head>
<body>
<form action=""  method="">
    <div class="header">
        <div class="wraper">
            <a href="{{asset('home/member/price')}}" >
				<span class="left">
				<img class="imgleft" src="{{url('images/base/back.png')}}">
				 </span>
            </a>
            <span class="title">冻结金提现</span>
        </div>
    </div>
    <div class="content">
        <div class="wraper bg_white">
            <div class="info bg_white margin_top">
                <div class="common">
                    <span>提现方式:</span>
                    <select name="type" id="type">
                        <option value="0" selected>支付宝</option>
                        <option value="1">微信</option>
                    </select>
                </div>
                <div class="common">
                    <span>提现账号:</span>
                    <input type="text" name="cash2"  id="cash2" value="" maxlength="20" placeholder="请输入账号" onkeyup="if( !/^[\d-]*$/.test(this.value)){this.value='';}"/>
                </div>

            </div>
        </div>
    </div>
    <span class="warn">&nbsp;&nbsp;&nbsp;&nbsp;提示：全部提现</span>
    <div class="appcheck">
        <button class="appcash" id="checkbtn">&nbsp;&nbsp;查看是否符合要求&nbsp;&nbsp;</button>
    </div>
    <div class="appbox">
        <button class="appcash" id="appbtn" type="submit">&nbsp;&nbsp;提现&nbsp;&nbsp;</button>
    </div>
</form>
</body>
<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('common/layer/layer.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script>
    var cashUrl=''
</script>
<script src="{{asset('js/member/cashtype.js')}}"></script>
</html>
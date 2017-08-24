<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>产品详情</title>
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css')}}" />
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('common/layer/mobile/need/layer.css')}}" rel="stylesheet">
    <link href="{{ asset('css/home/product/proDetail.css') }}" rel="stylesheet">
    <link href="{{ asset('ucqqshare/nativeShare.css') }}" rel="stylesheet">
</head>
<body>
<div id="output" style="display: none;"></div>
{{--产品图片区--}}
<div class="proImgPart">

    <a href="{{$backUrl}}" class="return back"><img src="{{asset('images/base/left.png')}}"></a>

    {{--输入框放url地址--}}
    <input id="urlInput" style="opacity: 0;position: absolute;" value="">
    <a class="shopCartHref" href="{{url('/home/shopping/shopCart')}}"><img src="{{asset('images/base/shopCartHref.png')}}"></a>
    <span class="share" data-clipboard-target="#urlInput"><img src="{{asset('images/base/share.png')}}"></span>

    <div class="proImg swiper-container">
        <div class="swiper-wrapper">
            @foreach($data['dataPro']->pic as $value)

                <div class="swiper-slide">
                    <img src="{{PRO_IMG_PATH . $value}}">
                </div>


            @endforeach
        </div>
        <div class="swiper-pagination"></div>

    </div>

    @if(isset($data['dataPro']->show_time) && isset($data['dataPro']->end_time))

        {{--如果是限时抢购，限时该部分--}}
        <div class="timeLimit">
            <input type="hidden"class="timet" value="{{ $data['dataPro']->end_time }}"/>
            <div class="time">
                <span class="t_d" style="float: left;">00天</span>
                <span class="t_h" style="float: left;">00时</span>
                <span class="t_m" style="float: left;">00分</span>						<!--<span class="t_s">00秒</span>-->
            </div>
            <span class="timel"></span>
            <img class="bgImg" src="{{asset('images/base/timelimit.png')}}">
        </div>
    @endif

</div>
{{--产品图片区结束--}}

{{--产品名称、收藏、销量--}}
<div class="proInfo">
    <span class="proName">{{$data['dataPro']->name}}</span>{{--如果收藏了显示2--}}
    @if($data['collect'] == false)
        <span class="collection collect"><img src="{{asset('images/base/collection1.png')}}"></span><br/>
    @else
        <span class="collection collect"><img src="{{asset('images/base/collection2.png')}}"></span><br/>
    @endif
    <span class="font">价格：</span>

    @if($data['max'] == $data['min'])
        <span class="proPrice">￥{{$data['max']}}</span>
    @else
        <span class="proPrice">￥{{$data['min']}} ~￥{{$data['max']}}</span>
    @endif
    <span class="sellNum">月销量：{{$data['dataPro']->volume}}</span>
</div>
<div id="content">

    {{--产品名称、收藏、销量结束--}}
    <span class="chooseBtn">请选择产品参数</span>

    {{--上传本地文件--}}
    <div class="uploadImg btn-upload"  id="file">
        @if(session($userId.'_'.$data['dataPro'] -> id.'_'.$data['typeNumber'].'_'.'picName1') || session($userId.'_'.$data['dataPro'] -> id.'_'.$data['typeNumber'].'_'.'picName2') )
        <a id="filebtn" href="{{url('home/product/uploadRequire')}}/{{ $data['dataPro'] -> id }}/{{ $data['typeNumber'] }}">查看上传</a>
        @else
        <a id="filebtn" href="{{url('home/product/uploadRequire')}}/{{ $data['dataPro'] -> id }}/{{ $data['typeNumber'] }}">上传需求</a>
        @endif
            {{--<span  class="delImg"  href="javascript:;" style="display:none;">删除上传文件</span>--}}
        {{--<input type="file" id="image_upload" name="file">--}}
    </div>
    <ul class="detailList">
        <li class="itemList"><a class="listName chosen" href="#proDetail">产品详情</a></li>
        <li class="itemList"><a class="listName" href="#rates">购买评价</a></li>
    </ul>
</div>

{{--产品详情、参数、评价--}}
<div class="mainContent">
    <div class="line"></div>
    <div class="mixContent">
        {{--产品详情开始--}}
        <div id="proDetail">
            {!!$data['dataPro']->content!!}
        </div>
        {{--产品详情结束--}}

        {{--评价--}}
        <div id="rates">
            @foreach($data['comment'] as $value)
                <div class="rate">
                    <div class="headPic">
                        <img data-original="{{url('uploads/user/'."$value->pic")}}">
                        <span class="userName">{{$value->name}}</span>
                    </div>
                    <div  class="rateContent">
                        <span>{{$value->content}}</span><br/>
                        <img data-original="{{url('uploads/comment/'."$value->image")}}">

                    </div>
                </div>
            @endforeach

        </div>
        {{--评价结束--}}
    </div>
</div>
<div class="hasInBotm">亲，已经到底部了哦~~</div>
{{--底部开始--}}

<ul class="footer">
    <li class="footItemList">
        <span class="qqChat"><img src="{{asset('images/base/service.png')}}">客服</span>
        @if($data['collect'] == false)
            <span class="collect"><img src="{{asset('images/base/collection1.png')}}">收藏</span>
        @else
            <span class="collect"><img src="{{asset('images/base/collection2.png')}}">收藏</span>
        @endif
    </li>
    <li class="addCart"><img src="{{asset('images/base/shopCart.png')}}">加入购物车</li>
    <li class="buyNow"><img src="{{asset('images/base/pay.png')}}">立即购买</li>
</ul>

{{--底部结束--}}


{{--属性弹框开始--}}
{{--遮罩--}}
<div class="overLay"></div>
<div class="paramModel">

    @if($data['max'] == $data['min'])
        <span class="proPrice priPosition">￥{{$data['max']}}</span>
    @else
        <span class="proPrice priPosition">￥{{$data['min']}} ~￥{{$data['max']}}</span>
    @endif
    <img class="closeImg" src="{{asset('images/base/close.png')}}">
    <div id="paramBody">
        @foreach($data['attrName'] as $key=>$value)
            <div class="params">
                <span class="attrName" >{{$value}}：</span><br/>
                <ul class="attrList singleAttr" id="{{$key}}">
                    @if($data['attrType'][$key] == 1 )
                        <span class="beizhu">(可不选，可多选)</span>
                        {{--多选属性--}}
                        @for($j = 0; $j < count($data['attrArr'][$key]); $j++)
                            <p attrName = "{{$key}}" value="{{$data['attrArr'][$key][$j]}}"  class="attrItem" price="{{$data['attr_price'][$data['attrArr'][$key][$j]]}}"> {{$data['attrArr'][$key][$j]}}</p>
                        @endfor
                    @elseif($data['attrType'][$key] == 2 )
                        @for($j = 0; $j < count($data['attrArr'][$key]); $j++)
                            {{--自定义属性--}}
                            <li attrName = "{{$key}}" class="attrItem inputParent" value="{{$data['attrArr'][$key][$j]}}">
                                <input class="type2" attrName = "{{$key}}" type="number" maxlength="6" value="{{$data['attrArr'][$key][$j]}}">
                            </li>
                        @endfor
                    @else
                        @for($j = 0; $j < count($data['attrArr'][$key]); $j++)
                            {{--单选属性--}}
                            <li attrName = "{{$key}}" class="attrItem singleAttrLi" value={{$data['attrArr'][$key][$j]}}>{{$data['attrArr'][$key][$j]}}</li>
                        @endfor

                    @endif
                </ul>
            </div>

        @endforeach
    </div>
    {{--弹框的底部--}}
    {{--点击选择产品参数--}}
    <div class="modelFooter chooseBtnClick">
        <span class="spanStyle addCartClick">加入购物车</span>
        <span class="spanStyle buyNowClick">立即购买</span>
    </div>
    {{--点击加入购物车时--}}
    <div class="modelFooter addCartClick">
        <span class="btnStyle">确定</span>
    </div>
    {{--点击立即购买时--}}
    <div class="modelFooter buyNowClick">
        <span class="btnStyle">确定</span>
    </div>

</div>

{{--规格弹框结束--}}
{{--调用QQ和UC浏览器所需--}}
<div id="nativeShare" style="display: none;"></div>

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


{{--右下角的返回首页--}}
<a class="returnHome" href="{{url('home/index')}}">
    <img src="{{asset('images/base/returnHome.png')}}" />
</a>

{{--右下角的返回顶部--}}
<a class="circle">
    <img src="{{asset('images/base/top.png')}}" />
</a>

<input type="hidden" id="qaz" value="{{$data['attrsjson']}}">

<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('common/layer/layer.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/swiper.min.js')}}"></script>
{{--<script src="{{asset('js/goback.js')}}"></script>--}}
<script type="text/javascript">
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    spaceBetween: 30,
    loop:true,
});
</script>
{{--上传文件需要--}}
{{--<script src="{{asset('js/upload/jquery.ui.widget.js')}}"></script>--}}
{{--<script src="{{asset('js/upload/jquery.fileupload.js')}}"></script>--}}
{{--<script src="{{asset('js/upload/jquery.fileupload-process.js')}}"></script>--}}
{{--<script src="{{asset('js/upload/jquery.fileupload-validate.js')}}"></script>--}}
{{--<script src="{{asset('js/upload/jquery.iframe-transport.js')}}"></script>--}}
{{--兼容浏览器的复制功能--}}
<script src="{{asset('browserCopy/dist/clipboard.min.js')}}"></script>
{{--分享仅支持UC和QQ浏览器--}}
<script src="{{asset('ucqqshare/nativeShare.js')}}"></script>
<script>
    var proId = '{{$data['dataPro']->id}}';
    var typeNumber = '{{$data['typeNumber']}}';
    var filename = '';
    var urlCollect = "{{url('home/product/collect')}}";//收藏地址
    var UPurl = "{{url('home/product/upload')}}/{{$data['dataPro']->id}}";//文件上传地址
            {{--var durl = "{{url('home/product/')}}";//删除上传文件时的地址--}}
    var urlOrder = "{{url('home/shopping/order')}}";//立即购买跳转地址
    var urlBuy = "{{url('home/shopping/buy')}}";//立即购买临时地址
    var urlCart = "{{url('home/shopping/cart')}}";  // 购物车
    var loginUrl="{{ url('login') }}";//登录的路径
    var attrs = new Object();
    attrs = $.parseJSON($("#qaz").val());//所有组合数组（不含多选属性）
    var imgSrc ="{{url(PRO_IMG_PATH . $data['dataPro']->thumbing)}}" ;//图片logo地址
//    console.log("jjjjjjjjjjj",imgSrc);
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



</script>
<!--延时加载-->
    <script src="{{asset('js/jquery.lazyload.js?v=1.9.1')}}"></script>
    <script src="{{asset('js/lazyload.js')}}"></script>
<script src="{{asset('js/product/proDetail.js')}}"></script>
<script src="{{asset('js/home/base/baseSingle.js')}}"></script>
{{--手机端调试时引入下面的文件--}}
{{--<script src="http://192.168.2.104:8023/target/target-script-min.js#anonymous"></script>--}}
</body>
</html>
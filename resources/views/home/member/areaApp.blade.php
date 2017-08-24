<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>加盟商代理</title>
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/member/addressEdite/addressEdite.css') }}" rel="stylesheet">
</head>
<body>
<div class="header">
    <div class="wraper">
				<span class="left back">
				<img class="imgleft" src="{{asset('images/base/back.png')}}">
					
			</span>
        <span class="title">加盟商代理</span>
    </div>
</div>
<div class="content">
    <div class="wraper bg_white">

       <form >
           {{csrf_field()}}
           <div class="info bg_white margin_top">
               <div>
                   <span class="areas"> 请输入加盟区域</span>
               </div>
               <div class="common common2">
                   <select class="province" name="procince" id="province"></select>
                   <select class="city" name="city" id="city"></select>
                   <select class="district" name="district" id="district"></select>
               </div>
               <div class="common3">
                   <div class="common">
                   <span>详细地址:</span>
               </div>

                   <textarea type="text" name="detail" id="detail" placeholder="请输入加盟商具体区域" required></textarea>
           </div>
           <div>
               <span>温馨提示：注册加盟商需缴纳10000元押金。</span>
           </div>
           </div>
           <div class="group" id="ok">
               <button  type="button" >
                   完成
               </button>
           </div>
       </form>
        <!--		<div class="footer">
        <a href="#javascript:;">退出当前账户</a>
        </div>-->
</body>
<script src="{{asset('js/jquery-3.0.0.min.js')}}"></script>
<script src="{{asset('js/rem.js')}}"></script>
<script src="{{asset('js/goback.js')}}"></script>
<script src="{{asset('js/data.js')}}"></script>

<script>
//    var a = $('#province').html();
//    console.log("sdf"+a);
</script>
<script>
    //		三级联动
    function options(data) {
        var options;
        for(var i in data) {
            options += '<option value=' + i + '>' + data[i] + '</option>'
        }
        return options
    }
    //	生成省
    $(".province").html(options(datas[86]));
    var proindex = $(".province").val();
    $('.city').html(options(datas[proindex]));
    var cityindex = $('.city').val();
    $('.district').html(options(datas[cityindex]))

    //生成相应市

    $('.province').change(function() {
        var index = $(this).val();
//      console.log(index)
        $('.city').html(options(datas[index]));
         var index2 = $('.city').val();
//      console.log(index);
        $('.district').html(options(datas[index2]))

    })
    //生成相应的区
    $('.city').change(function() {
//      console.log(111);
        var index = $(this).val();
//      console.log(index)
        $('.district').html(options(datas[index]))

    })

    //发送数据的地址
    var url = "{{ url('/home/member/areaApp') }}";

</script>
<script src="{{asset('js/member/areaApp.js')}}"></script>
</html>
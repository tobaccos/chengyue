//联系客服，随机接入客服
var serviceArr = [];

//客服的qq号
var service1="http://wpa.qq.com/msgrd?v=3&uin=862875277&site=qq&menu=yes";
var service2="http://wpa.qq.com/msgrd?v=3&uin=1702688881&site=qq&menu=yes";
var service3="http://wpa.qq.com/msgrd?v=3&uin=1702688882&site=qq&menu=yes";
var service4="http://wpa.qq.com/msgrd?v=3&uin=1702688883&site=qq&menu=yes";
var service5="http://wpa.qq.com/msgrd?v=3&uin=1702688884&site=qq&menu=yes";
var service6="http://wpa.qq.com/msgrd?v=3&uin=862875277&site=qq&menu=yes";
var service7="http://wpa.qq.com/msgrd?v=3&uin=862875277&site=qq&menu=yes";
var service8="http://wpa.qq.com/msgrd?v=3&uin=862875277&site=qq&menu=yes";

serviceArr =[service1,service2,service3,service4,service5,service6,service7,service8];

var servLen =serviceArr.length;//客服数量
//随机客服对应的index
var servIndex =   Math.floor(Math.random()*servLen);
var chatUrl =serviceArr[servIndex];

//点击客服隐藏显示
$(".qqChat").click(function(){
	$(".kuang").fadeIn(500);
	$(".qq").fadeIn(500);
});
$(".closes").click(function(){
	$(".kuang").fadeOut(500);
	$(".qq").fadeOut(500);
});

//唤起客服
$(".qqChoose li").click(function () {
	var servIndex = $(this).index();//获取li是第几个
    var chatUrl =serviceArr[servIndex];//选取数组中的第几个客服
    window.location.href=chatUrl;
});

//搜索框
$(".search_btn").click(function () {
	var searchWord = $(".search").val();
    $.ajax({
        type: "POST",
        url: lll,
        data:{searchWord:searchWord},
        // dataType: "json",
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg){


        },
        error:function(data){
            console.log('错误');
        }
    });
});

//底部导航点击事件

(function() {

    //方法1
    $(".footItem li img").click(function() {
        //获取选中的背景路径
        var url = $(this).attr('src');
        //修改路径
        url = url.replace(/1.png/, '2.png');
        //替换路径

        //获取其他li
        var siblings = $(this).parents('ul.footItem').find('img');
        //循环其他li
        for(var i = 0; i < siblings.length; i++) {
            //获取背景路径
            var urls = $(siblings[i]).attr('src');
            //修改路径
            urls = urls.replace(/2.png/, '1.png');
            //替换路径
            $(siblings[i]).attr('src', urls);
        }
        $(this).attr('src', url);
    });

    //方法2
	/*	function url2(option){
	 //获取选中的背景路径
	 var url = $(option).css('background-image');
	 //修改路径
	 url = url.replace(/1.png/, '2.png');
	 //替换路径
	 $(option).css('background-image', url);
	 };
	 function url1(option){
	 //获取选中的背景路径
	 var url = $(option).css('background-image');
	 //修改路径
	 url = url.replace(/2.png/, '1.png');
	 //替换路径
	 $(option).css('background-image', url);
	 };


	 $(".footItem li").click(function() {
	 url2(this);
	 //获取其他li
	 var siblings = $(this).siblings();
	 //循环其他li
	 for(var i = 0; i < siblings.length; i++) {
	 url1(siblings[i])
	 }

	 });*/

    //方法3
	/*	function url(option, op1, op2) {
	 //获取选中的背景路径
	 var url = $(option).css('background-image');
	 //修改路径
	 url = url.replace(op1, op2);
	 //替换路径
	 $(option).css('background-image', url);
	 };

	 $(".footItem li").click(function() {
	 url(this, '1.png', "2.png");
	 //获取其他li
	 var siblings = $(this).siblings();
	 //循环其他li
	 for(var i = 0; i < siblings.length; i++) {
	 url(siblings[i], "2.png", '1.png')
	 }

	 });*/


})()
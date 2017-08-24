$(".hnav ul li").click(function(){
	$(this).addClass("current").siblings().removeClass("current")
})
//分类全选或全不选
var urlfalse = $(".choseItem").children('img').attr('src');
var urltrue = urlfalse.replace(/false.png/, 'true.png');
//console.log(urltrue);
$(".choseItem").click(function() {
	var url = $(this).children('img').attr('src');
	var url2 = /false/.test(url) ? urltrue : urlfalse;
	$(this).children('img').attr('src', url2);
	$(this).parent().siblings().find('.chose img').attr('src', url2)
})

//全选或全不选
$(".all").click(function() {
	var url = $(this).children('img').attr('src');
	var url2 = /false/.test(url) ? urltrue : urlfalse;
	$(this).children('img').attr('src', url2);
	$('.choseItem').children('img').attr('src', url2)
	$('.choseItem').parent().siblings().find('.chose img').attr('src', url2)
})
//单击其中的一个
$('.chose').click(function() {
	var url = $(this).children('img').attr('src');
	var url2 = /false/.test(url) ? urltrue : urlfalse;
	$(this).children('img').attr('src', url2);

	var haha = $(this).parent().parent().parent('.con-info').find(".chose");
	//	console.log(haha)
	//	var url = $(this).children('img').attr('src');
	var urls = [];
	haha.each(function() {
		urls.push($(this).children().attr('src'));
	});
	if(/false/.test(urls)) {
		//		console.log(111);
		//		console.log($(this).parent().parent().parent('.con-info').siblings('.con-head'));
		$(this).parent().parent().parent('.con-info').siblings('.goods-header').children().children('img').attr('src', urlfalse)
	} else {
		//		console.log(222);

		$(this).parent().parent().parent('.con-info').siblings('.goods-header').children().children('img').attr('src', urltrue)

	};

});
var choose = $(".choseItem")
//alert(choose.length)
var num = choose.length;
var arr = 0;
$(".choseItem img").each(function(){
	var a = $(this).find("img").attr("src");
	console.log(a)
//	if(a.indexOf("true") != -1){
//		arr++
//	}	
})
$(".choseItem").click(function(){
	if(num == arr){
		$(".all img").attr("src",urltrue);
	}else{
		$(".all img").attr("src",urlfalse);
	}
})
//去结算
$(".ban-go").click(function(){
	var imgs = $('.choseItem').find('img');
//	console.log(imgs);

	var datas = [];
	imgs.each(function(index, item) {
	
		if($(item).attr('src') == urltrue) {
		  var orderlist = $(this).parent().prev().val();
		  datas.push(orderlist);
		};
	})
	$('#data').val(datas);
// console.log($('#data').val());
	//发送数据

	 $('#jiesuan').submit();
});


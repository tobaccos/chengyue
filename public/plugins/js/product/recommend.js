//排序的点击事件
var checkSortValue =[];//已选分类
$(".orderItem li").click(function(){
	$(this).addClass("choosed").siblings().removeClass("choosed");
	//排序
	var sortType = $(this).attr('value') ;
    var searchWrod = $('.search').val();

	$.ajax({
		type: "POST",
		url: urlAll,
		data: {searchWrod:searchWrod,minPrice:minPriceInput,maxPrice:maxPriceInput},
		dataType: "json",
		headers:{
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		success: function(msg){
            console.log(msg);
			$('.proItem').html(msg);
		},
		error:function(data){
			console.log('bbbbb');
		}
	});
});

//搜索查询
$('.searchBtn').click(function(){
	var searchWrod = $('.search').val();
    if(checkSortValue.length>0){
        type_id = checkSortValue;
    }
    $.ajax({
        type: "POST",
        url: urlAll,
        data: {searchWrod:searchWrod,minPrice:minPriceInput,maxPrice:maxPriceInput},
        dataType: "json",
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg){
        	console.log(msg);
        	if (msg !="") {
                $('.proItem').html(msg);
            }
            else {
        	    str="<img class='nomore' src='../../../images/base/nomore.png' style='width: 100%;'/>";
                $('.proItem').html(str);
                //将排序禁止点击
                $(".orderItem li").css("pointer-events","none");
            }
        },
        error:function(data){
            console.log('bbbbb');
        }
    });
});
//点击筛选，筛选弹出框弹出
$(".sortCheck").click(function () {
    $(".checkModel").show();
    $(".overLay").show();
});
//选择筛选弹出框的分类

$(".sortItem li").click(function () {
	if(!$(this).hasClass("sortChoose")){
        $(this).addClass("sortChoose");
        checkSortValue.push($(this).attr("value"));
	}else {
        $(this).removeClass("sortChoose");
        removeByValue(checkSortValue,$(this).attr("value"));
	}
});

//点击弹出框的确定按钮时
var minPriceInput='';
var maxPriceInput='';
$(".checkSure").click(function () {
    //输入的最低价钱
    minPriceInput =$(".minPriceInput").val();
    //输入的最高价钱
    maxPriceInput =$(".maxPriceInput").val();
    // if(checkSortValue.length>0){
    //     type_id = checkSortValue;
    // }
    $.ajax({
        type: "POST",
        url: urlAll,
        data: {minPrice:minPriceInput,maxPrice:maxPriceInput},
        dataType: "json",
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg){
            console.log(msg);
            $('.proItem').html(msg);
        },
        error:function(data){
            console.log('bbbbb');
        }
    });

    $(".checkModel").hide();
    $(".overLay").hide();
});

//点击遮罩层
$(".overLay").click(function () {
    $(".checkModel").hide();
    $(".overLay").hide();
});
//删除数组指定值
function removeByValue(arr, val) {
    for(var i=0; i<arr.length; i++) {
        if(arr[i] == val) {
            arr.splice(i, 1);
            break;
        }
    }
}
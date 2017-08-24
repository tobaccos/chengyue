//排序的点击事件
//var checkSortValue = []; //已选分类
var ids = [];
ids = type_id;
$(".orderItem li").click(function() {
    $(this).addClass("choosed").siblings().removeClass("choosed");
    //排序
    var sortType = $(this).attr('value');
    var searchWrod = $('.search').val();
    if (!$(this).hasClass('sortCheck')) {
        $(".checkModel").hide();
        $(".overLay").hide();
        $.ajax({
            type: "POST",
            url: urlAll,
            data: {
                type_id: ids,
                sortType: sortType,
                searchWrod: searchWrod,
                minPrice: minPriceInput,
                maxPrice: maxPriceInput
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(msg) {
                //         console.log(msg);
                if (msg != "") {
                    $('.proItem').html(msg);
                } else {
                    str = "<img class='nomore' src='" + url2 + "' style=' width:10rem;'/>";
                    $('.proItem').html(str);
                    //将排序禁止点击
                    //				$(".orderItem li").css("pointer-events", "none");
                }
            },
            error: function(data) {
                console.log('bbbbb');
            }
        });
    }


});
var words = [];
//搜索查询
$('.searchBtn').click(function() {
    $("#keywords").hide();
    words.shift();
    var searchWrod = $('.search').val();
    words.push(searchWrod);
    //	if(checkSortValue.length > 0) {
    //		type_id = checkSortValue;
    //	}
    $.ajax({
        type: "POST",
        url: urlAll,
        data: {
            searchWrod: searchWrod,
            //			type_id: type_id,
            //			minPrice: minPriceInput,
            //			maxPrice: maxPriceInput
        },
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg) {
            //      	console.log(msg);
            if (msg != "") {
                $('.proItem').html(msg);
            } else {
                str = "<img class='nomore' src='" + url2 + "' style=' width:10rem;'/>";
                $('.proItem').html(str);
                //将排序禁止点击
                //				$(".orderItem li").css("pointer-events", "none");
            }
        },
        error: function(data) {
            console.log('bbbbb');
        }
    });
});
//查询词显示
$(".search").keyup(function() {
    if (words.length > 0) {
        $("#keywords").html("<li>" + words[0] + "</li>").show();

    }

});
$(".search").blur(function() {
    $("#keywords").hide()
})

$("#keywords").click(function() {
    $(".search").val($(this).text());
    $(this).hide();
})

//点击筛选，筛选弹出框弹出
$(".sortCheck").click(function() {
    $(".checkModel").show();
    $(".overLay").show();
    $(".minPriceInput").val('');
    $(".maxPriceInput").val('');
    $('.orderSelected').html('');
    ids = [];
    objs = [];

});

//选择筛选弹出框的分类

$(".sortItem li").click(function() {
    if (!$(this).hasClass("sortChoose")) {
        $(this).addClass("sortChoose");

    } else {
        $(this).removeClass("sortChoose");
    };
    var objss = [];
    var idss = [];
    $('.sortItem li').each(function() {
        var obj = {};
        if ($(this).hasClass('sortChoose')) {
            obj['id'] = $(this).val();
            obj['text'] = $(this).text();
            objss.push(obj);
            idss.push($(this).val());
        }
    });

    ids = idss;
    objs = objss;
});

//点击弹出框的确定按钮时
var minPriceInput = '';
var maxPriceInput = '';
$(".checkSure").click(function() {
    $('.orderSelected').css('max-height', '0.635rem');
    //输入的最低价钱
    minPriceInput = $(".minPriceInput").val();
    //输入的最高价钱
    maxPriceInput = $(".maxPriceInput").val();

    $.ajax({
        type: "POST",
        url: urlAll,
        data: {
            type_id: ids,
            minPrice: minPriceInput,
            maxPrice: maxPriceInput
        },
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg) {
            //          console.log(msg);

            if (msg != "") {
                $('.proItem').html(msg);

            } else {
                str = "<img class='nomore' src='" + url2 + "' style=' width:10rem;'/>";
                $('.proItem').html(str);
                //将排序禁止点击
                //				$(".orderItem li").css("pointer-events", "none");
            };
            //选中的筛选条件
            var orderCont = '<div class="orderCont"></div>';
            $('.orderSelected').append(orderCont);
            objs.forEach(function(item) {
                var htmls = '<span class="selects" data-id="' + item.id + '" >' + item.text + '<img src="' + urlClose + '"></span>';
                console.log("htmls", htmls);
                $('.orderCont').append(htmls)
            });
            var prices = '';
            console.log(minPriceInput);
            if (minPriceInput && maxPriceInput) {
                // if(minPriceInput < maxPriceInput){
                    console.log(11111);
                    prices = '<span class="selects prices">价格区间:' + minPriceInput + "-" + maxPriceInput + '<img src="' + urlClose + '"></span>';
                    $('.orderCont').append(prices);
                // }
                // if(minPriceInput > maxPriceInput){
                //     var middlePrice = maxPriceInput;
                //     maxPriceInput =minPriceInput;
                //     minPriceInput = middlePrice;
                //     console.log(11111);
                //     prices = '<span class="selects prices">价格区间:' + minPriceInput + "-" + maxPriceInput + '<img src="' + urlClose + '"></span>';
                //     $('.orderCont').append(prices);
                // }


            };
            if (minPriceInput && !maxPriceInput) {
                prices = '<span class="selects prices">最低价格:' + minPriceInput + '<img src="' + urlClose +'"></span>';
                $('.orderCont').append(prices)

            };
            if (!minPriceInput && maxPriceInput) {
                prices = '<span class="selects prices">最高价格:' + maxPriceInput + '<img src="' + urlClose + '"></span>';
                $('.orderCont').append(prices)

            };

            if (objs.length > 0 || prices) {

                var shows = '<em class="shows">展开</em>';
                var hides = '<em class="hides">关闭</em>';
                var clear = '<em class="clear">清空</em>';
                $('.orderSelected').append(shows);
                $('.orderSelected').append(hides);
                $('.orderSelected').append(clear);
            };
            // 展开筛选条件
            $(".shows").click(function() {
                $('.orderSelected').css('max-height', 'none');
            })

            // 触摸手机屏就关闭筛选条件
            $('.proItem').on('touchstart', function() {
                $('.orderSelected').css('max-height', '0.635rem')
            })



            $('.sortItem li').each(function(index, item) {
                //				console.log(item);
                if ($(item).hasClass('sortChoose')) {
                    $(item).removeClass('sortChoose');
                }
            });
            $('.selects').click(function() {
                var ids = [];
                $(this).remove();
                var siblings = $('span.selects');
                //				console.log(siblings);
                if (siblings.length == 0) {
                    $('.clear').remove()
                };
                siblings.each(function() {
                    ids.push($(this).attr('data-id'))
                });
                if ($(this).hasClass('prices')) {
                    minPriceInput = '';
                    maxPriceInput = '';
                    console.log(222);
                    $.ajax({
                        type: "POST",
                        url: urlAll,
                        data: {
                            type_id: ids,

                        },
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(msg) {
                            //          console.log(msg);

                            if (msg != "") {
                                $('.proItem').html(msg);

                            } else {
                                str = "<img class='nomore' src='" + url2 + "' style=' width:10rem;'/>";
                                $('.proItem').html(str);
                                //将排序禁止点击
                                //							$(".orderItem li").css("pointer-events", "none");
                            };
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: urlAll,
                        data: {
                            type_id: ids,
                            minPrice: minPriceInput,
                            maxPrice: maxPriceInput
                        },
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(msg) {
                            //          console.log(msg);

                            if (msg != "") {
                                $('.proItem').html(msg);

                            } else {
                                str = "<img class='nomore' src='" + url2 + "' style=' width:10rem;'/>";
                                $('.proItem').html(str);
                                //将排序禁止点击
                                //							$(".orderItem li").css("pointer-events", "none");
                            };
                        }
                    });
                }

            });

            //	清空
            $('.clear').click(function() {
                ids = type_id;
                minPriceInput = '';
                maxPriceInput = '';
                $(".selects").remove();
                $(this).remove();

                $.ajax({
                    type: "POST",
                    url: urlAll,
                    data: {
                        type_id: ids,
                        minPrice: minPriceInput,
                        maxPrice: maxPriceInput
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(msg) {
                        //          console.log(msg);
                        ids = [];

                        if (msg != "") {
                            $('.proItem').html(msg);

                        } else {
                            str = "<img class='nomore' src='" + url2 + "' style=' width:10rem;'/>";
                            $('.proItem').html(str);
                            //将排序禁止点击
                            //				$(".orderItem li").css("pointer-events", "none");
                        };

                    }
                })

            });

        },
        error: function(data) {
            console.log('bbbbb');
        }
    });

    $(".checkModel").hide();
    $(".overLay").hide();
});

//点击遮罩层
$(".overLay").click(function() {
    $(".checkModel").hide();
    $(".overLay").hide();
});
//删除数组指定值
function removeByValue(arr, val) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == val) {
            arr.splice(i, 1);
            break;
        }
    }
}
//输入字符限制
$(".proName").each(function() {
    var text = $(this).text();
    //console.log( text.length)
    if (text.length > 12) {
        str = text.substr(0,12) + '...';
        $(this).text(str)
    }
})
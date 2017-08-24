//判断当前所用浏览器所需
var qApiSrc = {
    lower: "http://3gimg.qq.com/html5/js/qb.js",
    higher: "http://jsapi.qq.com/get?api=app.share"
};
var bLevel = {
    qq: {
        forbid: 0,
        lower: 1,
        higher: 2
    },
    uc: {
        forbid: 0,
        allow: 1
    }
};
var UA = navigator.appVersion;
var isqqBrowser = (UA.split("MQQBrowser/").length > 1) ? bLevel.qq.higher : bLevel.qq.forbid;
var isucBrowser = (UA.split("UCBrowser/").length > 1) ? bLevel.uc.allow : bLevel.uc.forbid;
//判断当前所用浏览器所需结束

//点击分享时
$(".share").click(function() {
    var proName = $('.proName').text();
    $("#urlInput").val(shareUrl); //设置输入框的内容
    var stopIndex = $("#urlInput").val(); //获取输入框现在的值
    var input = document.getElementById("urlInput"); //选中input框
    input.focus(); //聚焦
    input.setSelectionRange(0, stopIndex.length); //选中输入框中的内容

    input.blur(); //然后让其失去焦点则不会唤起手机的输入法，缺陷是，会抖一下
    //点击分享，弹出qq和微信两个图标
    var btn1 = "<span class='QQs'><img src=../../../../images/base/qq.png></span>";
    var btn2 = "<span class='weixinS'><img src=../../../../images/base/weixin.png></span>";

    if(isqqBrowser || isucBrowser) {
        var titlePro = '';
        var contentPro = '';
        titlePro = prompt("请输入分享标题", proName);
        //点击确定的话再走下一步
        if(titlePro) {
            contentPro = prompt("请输入分享描述", "印刷我们最专业");
            //点击确定的话再走下一步
            if(contentPro) {
                // 用QQ和UC浏览器自带的分享功能
                var config = {
                    url: shareUrl,
                    title: titlePro,
                    desc: contentPro,
                    img: imgSrc,
                    img_title: '印刷我们最专业',
                    from: '印汇商盟'
                };
                var share_obj = new nativeShare('nativeShare', config);
                $("#nativeShare").show();
                //关闭分享选择框
                $(".shareClose").click(function() {
                    $("#nativeShare").hide();
                });
            }
        }



    } else {
        // document.write('目前该分享插件仅支持手机UC浏览器和QQ浏览器');
        document.getElementById("nativeShare").style.display = "none";
        if(window.execCommand) {
            document.execCommand('copy'); // 执行浏览器复制命令
        } else {
            var msg = prompt('请手动复制分享地址', proName + ': ' + shareUrl);
            if(msg) {
                //分享方法
                layer.confirm('选择分享方式去粘贴', {
                    btn: [btn1, btn2] //按钮
                }, function() {
                    //唤起QQ
                    var qq = "mqqapi://";
                    window.location.href = qq;
                }, function() {
                    //唤起微信
                    var weixin = "weixin://";
                    window.location.href = weixin;
                });
            } else {

            }

        }
    }

});

//产品详情、参数、评价的切换效果
$(".listName").click(function() {
    $('.detailList a').css({
        "color": "#4e4e4e"
    });
    $(this).css({
        "color": "#ff3600",
        "text-decoration": "none"
    });

    var divAll = $(".mixContent div");
    //要显示的div的id
    var idShow = $(this).attr("href");
    //获取mixContent的div的id
    for(var i = 0; i < divAll.length; i++) {
        var divId = $(divAll[i]).attr("id");
        if('#' + divId == idShow) {
            $(idShow).show();
        } else {
            $('#' + divId).hide();
        }
    }
});

// 点击收藏
$(".collect").click(function() {
    //页面中的两个收藏图标
    var collects = $(".collect img");
    var url = "";

    $.ajax({
        type: "POST",
        url: urlCollect,
        data: {
            proId: proId,
            typeNumber: typeNumber
        },
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg) {
            console.log(msg);
            //如果没登录，点击跳转登录，如果登录了，
            if(msg == "请登录") {
                var str = "<p class='layFont'>" + msg + "</p>";
                layer.msg(str, {
                    time: 1000
                }, function() {
                    window.location.href = loginUrl;
                });
            } else {
                for(var i = 0; i < collects.length; i++) {
                    url = $(collects[i]).attr('src');
                    // 如果没有收藏则变成收藏
                    if(url.indexOf('1.png') > 0) {
                        //修改路径
                        url = url.replace(/1.png/, '2.png');
                        //替换路径
                        $(collects[i]).attr('src', url);
                    }
                    //如果收藏过了，再点击则取消收藏
                    else if(url.indexOf('2.png') > 0) {
                        //修改路径
                        url = url.replace(/2.png/, '1.png');
                        //替换路径
                        $(collects[i]).attr('src', url);
                    }
                }
                if(msg == "0") {
                    var str1 = "<p class='layFont'>收藏成功</p>";
                    layer.msg(str1, {
                        time: 1000
                    });
                }

                if(msg == "1") {
                    var str2 = "<p class='layFont'>已取消收藏</p>";
                    layer.msg(str2, {
                        time: 1000
                    });
                }
            }

        },
        error: function(data) {
            console.log('bbbbb');
        }
    });

});


//点击请选择参数的时候
$(".chooseBtn").click(function() {
    // 遮罩层显示
    $(".overLay").show();
    //弹出框显示
    $(".paramModel").show();
    //对应的按钮显示
    $(".chooseBtnClick").show();
    $(".spanStyle").show();
});

//可多选点属性，单独
var selfAttrPrice = []; //存放可多选属性的价钱
var selfPriceAll = ''; //可多选属性的总价
var selfAttrObject = new Object();
var AttrName = '';
var selfAttr = []; //多选属性选了什么
$(".params p").click(function() {
    //获取多选属性所属的类型
    AttrName = $(this).attr("attrName");
    // 为点击按钮添加样式
    if(!$(this).hasClass("on")) {
        $(this).addClass("on");
        selfAttrPrice.push($(this).attr("price"));
        // console.log($(this).attr("price"));
        //存选中的属性
        selfAttr.push($(this).attr("attrname") + '_' + $(this).attr("value"));
    } else {
        $(this).removeClass("on");
        //删除取消属性的价钱
        removeByValue(selfAttrPrice, $(this).attr("price"));
        //删除取消的属性
        removeByValue(selfAttr, $(this).attr("attrname") + '_' + $(this).attr("value"));
    }
    selfAttrObject = selfAttr;
    //console.log("sdfsafasf",selfAttrObject);
    //对价钱求和
    selfPriceAll = selfAttrPrice.reduce(function(acc, val) {
        return parseFloat(acc) + parseFloat(val);
    }, 0);
    countPrice();
    // console.log("selfPriceAll",selfPriceAll)
});

//属性选择时
//声明一个对象存放选中值
var attrNameVal = new Object();
//操作时所用对象
var singleNameValue = new Object();
//点击
var hasOnNum='';
$('.params li').click(function() {
    //默认全都不可选
    $(".params li").addClass("clickDisable");
    // 为点击按钮添加样式
    if(!$(this).hasClass("on")) {
        $(this).addClass("on").siblings("li").removeClass("on");
    } else {
        $(this).removeClass("on");
    }
    //页面中带有on的元素数量
    hasOnNum = $(".params li.on").length;

    //获取点击的时的属性 和属性值
    var singleName = $(this).attr('attrName');
    var singlevalue = $(this).attr('value');

    //点击选中时，则将该元素的属性值存起来
    if($(this).hasClass('on')) {
        //存放在数组中 将点击的（累加的）
        attrNameVal[singleName] = singlevalue;
        singleNameValue[singleName] = singlevalue;
    } else {
        //如果是取消选中状态，则删除数组中对应值
        delete attrNameVal[singleName];
        delete singleNameValue[singleName];
    }
    //console.log("attrNameVal",attrNameVal)
    //选中元素中的最后一个元素的属性名(attrname)
    var lastClick = '';
    var lastClick2 = [];
    var lastClickArr = Object.keys(singleNameValue);

    if(lastClickArr.length > 0) {
        lastClick = lastClickArr[lastClickArr.length - 1];
    }

    if(lastClickArr.length > 1) {
        for(var g = 2; g <= lastClickArr.length; g++) {

            lastClick2.push(lastClickArr[lastClickArr.length - g]);

        }
    }

    //什么都没选时全可选
    if(hasOnNum == 0) {
        $(".params li").removeClass("clickDisable")

    }
    //存放与大数组比对后的结果
    var checkResPre = new Object();
    //判断选中数组是否存在于大数组中
    checkResPre = where(attrs, attrNameVal);
    //如果页面当中只有一个选中，则同级全可选，匹配数组中的可选
    if(hasOnNum == 1) {
        //将带有on的li的同级设置成可点的
        $(".params li.on").siblings("li").removeClass("clickDisable");
        //进行判断
        checkResult(checkResPre);
    }

    //两个及两个以上，则同级在匹配数组中的可选，匹配数组的可选
    if(hasOnNum >= 2) {
        //删除对象的最后一个属性

        var singleNameValue2 = new Object();
        var checkResPre2 = [];
        for(var e = 0; e < lastClick2.length; e++) {

            $.extend(singleNameValue2, singleNameValue);
            delete singleNameValue2[lastClick2[e]];
            checkResPre2.push(where(attrs, singleNameValue2));

        }

        delete singleNameValue[lastClick];

        //用删除最后一个元素的对象与源对象比较
        var checkResPre1 = where(attrs, singleNameValue);

        //选择时
        if($(this).hasClass("on")) {
            //将符合条件（与当前选中元素的attrname一样的并且在匹配数组里）的遍历出来

            for(var i = 0; i < checkResPre1.length; i++) {
                //设置同级满足条件的li可选
                $(this).siblings("li[value='" + checkResPre1[i][lastClick] + "']").removeClass("clickDisable")
                $('#' + lastClick).find("li[value='" + checkResPre1[i][lastClick] + "']").removeClass("clickDisable");
                //执行完以后，重新赋值，很重要！！！！
                singleNameValue[lastClick] = attrNameVal[lastClick];
            }

            //进行判断
            checkResult(checkResPre);

            for(var k = 0; k < lastClick2.length; k++) {
                for(var j = 0; j < checkResPre2[k].length; j++) {

                    $('#' + lastClick2[k]).find("li[value='" + checkResPre2[k][j][lastClick2[k]] + "']").removeClass("clickDisable");
                }
            }
        } else {
            //取消时，删除当前取消的元素

            for(var i = 0; i < checkResPre1.length; i++) {

                $('#' + lastClick).find("li[value='" + checkResPre1[i][lastClick] + "']").removeClass("clickDisable");

                delete singleNameValue[singleName];
            }
            //执行完以后，重新赋值，同样很重要！！！！！！！！！！！
            singleNameValue[lastClick] = attrNameVal[lastClick];
            //进行判断
            checkResult(checkResPre);

            for(var k = 0; k < lastClick2.length; k++) {
                for(var j = 0; j < checkResPre2[k].length; j++) {

                    $('#' + lastClick2[k]).find("li[value='" + checkResPre2[k][j][lastClick2[k]] + "']").removeClass("clickDisable");

                }

            }
        }
    }

    //进行判断
    checkResult(checkResPre);
    countPrice();

});


//弹出层的关闭
$(".closeImg").click(function() {
    // 遮罩层隐藏
    $(".overLay").hide();
    //弹出框隐藏
    $(".paramModel").hide();
    //底部三个按钮隐藏
    $(".chooseBtnClick").hide();
    $(".addCartClick").hide();
    $(".buyNowClick").hide();

    //如果已经选了参数改变显示
    if($(".attrList").children(".on").length > 0){
        $(".chooseBtn").html("已选择产品参数");
    }else {
        $(".chooseBtn").html("请选择产品参数");
    }
    //已上传需求显示已上传需求

});

//弹出层的关闭
$(".overLay").click(function() {
    $(".closeImg").click();
});


//对比对数组结果进行处理，!=0代表大数组存在该组合
//如果存在，则获取价钱
var price = '';
var price1 = '';

function checkResult(checkRes) {
    //若大数组存在当前所选组合的情况下
    if(checkRes != 0) {
        price = checkRes[0].price; //获取价钱
        //满足条件的设置可点
        $.each(checkRes, function(k, v) {
            $.each(v, function(k1, v2) {
                $(".params li[attrName = '" + k1 + "'][value='" + v2 + "']").removeClass("clickDisable");
            });
        });
    }
}

//输入框计算价钱
$('.params li input').keyup(function() {
    countPrice();
});

//计算价钱的方法
function countPrice() {
    price1 = price;
    //长宽输入框的val
    var lengthZ = [];

    //当输入框被选中时
    if($('.params li.on input').length > 0) {
        for(var i = 0; i < $('.params li.on input').length; i++) {
            //输入框的值
            var inputVal = $($('.params li.on input')[i]).val();
            //当用户将默认的1删除时，此时输入框为空，给它默认值1
            if(inputVal == "") {
                inputVal = 1;
            }
            lengthZ.push(inputVal);
        }
    }
    if(price1 == ""){
        price1 = parseFloat(selfPriceAll); //变成浮点
        price1 = price1.toFixed(2); //保留两位小数
    }else {
        price1 = parseFloat(price1); //变成浮点
        price1 += selfPriceAll; //加上可多选属性的价钱
        //对lengthZ里面的数据求乘积
        for(var j = 0; j < lengthZ.length; j++) {
            price1 = lengthZ[j] * price1;
        }

        price1 = parseFloat(price1); //变成浮点
        price1 = price1.toFixed(2); //保留两位小数
    }

    $(".proPrice").html('￥' + price1); //设置页面显示的价钱
    $(".proPrice").val(price);

}

//属性选择结束

//弹出框和页面中的加入购物车都使用的addCart类，
// 点击这两个的时候执行的判断（比如是否选了属性），然后判断通过，加入购物车成功
//点击加入购物车，
$(".addCart").click(function() {
    // 遮罩层显示
    $(".overLay").show();
    //弹出框显示
    $(".paramModel").show();
    //对应的按钮显示
    $(".addCartClick").show();

});
//立即购买，
$(".buyNow").click(function() {
    // 遮罩层显示
    $(".overLay").show();
    //弹出框显示
    $(".paramModel").show();
    $(".buyNowClick").show();
});
//购物车弹出框的确定按钮的点击，然后加入购物车成功

var moreChoose = $("span.beizhu").length;//多选属性行数
var allChoose =$(".singleAttr").length;//所有属性行数
var inputChoose =$(".inputParent").length;//自定义属性行数


$(".addCartClick").click(function() {
    console.log("duo",moreChoose);
    console.log("all",allChoose);
    console.log("zi",inputChoose);
    //    做一个判断，参数已选，然后点弹出框的确定,不定向选择可以不选
    //如果页面中有输入框
    if($(".inputParent").length > 0){
        console.log("有输入框");
        //如果输入框选中，并且单选属性选中的数量和页面中的单选属性数量一样
        if($(".inputParent.on").length == inputChoose && $(".singleAttrLi.on").length == allChoose - inputChoose - moreChoose ){
            addCart();
        }else {
            var str = "<p class='layFont'>请将属性选择完整</p>";
            layer.msg(str, {
                time: 1000
            });
        }
    }
    //页面中没有输入框的时候
    else{
        if($(".singleAttrLi.on").length == allChoose - moreChoose){
            addCart();
        }else {
            var str = "<p class='layFont'>请将属性选择完整</p>";
            layer.msg(str, {
                time: 1000
            });
        }
    }
    getInputVal(); //获取输入款输入的值
    $(".closeImg").click();
});

function addCart() {
    var datas = new Object();
    datas['attrNameVal'] = attrNameVal; //单选属性
    datas['price1'] = price1; //总价
    datas['selfAttrObject'] = selfAttrObject; //多选属性
    datas['typeNumber'] = typeNumber;
    datas['proId'] = proId;
    $.ajax({
        type: "POST",
        url: urlCart,
        data: {
            datas: datas
        },
        // dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        //没登录页可以
        success: function(msg) {
            console.log(msg);
            if(msg == "200") {

                var str = "<p class='layFont'>加入购物车成功</p>";
                layer.msg(str, {
                    time: 1000
                });
            }
        },
        error: function(data) {
            console.log('错误');
        }
    });
}



//弹出框的确定按钮跳转到订单页
$(".buyNowClick").click(function() {
    //跳到确认订单页，order.balde.php
    //如果页面中有输入框
    if($(".inputParent").length > 0){
        //如果输入框选中，并且单选属性选中的数量和页面中的单选属性数量一样
        if($(".inputParent.on").length == inputChoose && $(".singleAttrLi.on").length == allChoose - inputChoose - moreChoose){
            buy();
        }else {
            var str = "<p class='layFont'>请将属性选择完整</p>";
            layer.msg(str, {
                time: 1000
            });
        }
    }
    //页面中没有输入框的时候
    if($(".inputParent").length == 0){
        if($(".singleAttrLi.on").length == allChoose - moreChoose){
            buy();
        }else {
            var str = "<p class='layFont'>请将属性选择完整</p>";
            layer.msg(str, {
                time: 1000
            });
        }
    }
    getInputVal(); //获取输入款输入的值
    $(".closeImg").click();
});

function buy() {
    var allinfo = new Object();
    var allinfo1 = new Object();
    allinfo['attrNameVal'] = attrNameVal;
    allinfo['price1'] = price1;
    allinfo['selfAttrObject'] = selfAttrObject;
    allinfo['proId'] = proId
    allinfo['num'] = 1;
    allinfo['typeNumber'] = typeNumber;
    if(filename != '') {
        allinfo['filename'] = filename;
    }
    allinfo1[0] = allinfo;
    $.ajax({
        type: "POST",
        url: urlBuy,
        data: {
            allinfo: allinfo1
        },
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg) {
            if(msg == '1') {
                window.location = urlOrder;
            } else {
                congsole.log('请重试');
            }
        },
        error: function(data) {
            console.log('bbbbb');
        }
    });
}

//上传文件
// 图片上传调用的路径UPurl
// $("#filebtn").click(function(event) {
//     if($("#image_upload")) {
//         $("#image_upload").click();
//     }
// });

// $("#image_upload").click(function() {
//     // console.log(UPurl);
//     $('#image_upload').fileupload({
//         url: UPurl,
//         dataType: 'json',
//         //acceptFileTypes:/\.(rar|zip)/,
//         singleFileUploads: false, //关闭 队列
//         maxNumberOfFiles: 1,
//         maxFileSize: 5242880, // 5 MB
//         messages: {
//             acceptFileTypes: '，文件格式错误',
//             maxNumberOfFiles: '，文件过多！',
//             maxFileSize: '，要小于5M'
//         },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//         },
//         //每个文件上传请求的开始回调。如果这个回调返回false，则中止该文件上传请求。
//         send: function(e, data) {
//             console.log('开始');
//         },
//         // 失败回调
//         processfail: function(e, data) {
//             var strError = "<p class='layFont'> 上传失败" + data.files[data.index].error + "</p>";
//             // layer.msg('上传失败'+data.files[data.index].error);
//             layer.msg(strError, {
//                 area: ['4rem', '1rem'],
//                 time: 1000
//             });
//
//             return;
//         },
//         //过程中调用
//         process: function(e, data) {
//             console.log('上传中');
//         },
//         //成功回调
//         done: function(e, data) {
//
//             if(data.result.state == "404") {
//                 //提示
//                 var strLogin = "<p class='layFont'> 请先登录</p>";
//                 layer.msg(strLogin, {
//                     time: 1000
//                 }, function() {
//                     window.location.href = data.result.url;
//                 });
//
//             } else if(data.result.state == "403") {
//                 layer.msg(data.result.msg);
//             } else {
//                 $(".delImg").show();
//                 $(".js_uploadText").hide();
//                 //提示
//                 filename = data.result.filename;
//                 var strSuccess = "<p class='layFont'> 上传成功</p>";
//                 layer.msg(strSuccess, {
//
//                     time: 1000
//                 });
//             }
//         }
//     });
// });
//
// //用户删除上传的文件
// $(".delImg").click(function() {
//     layer.msg("删除成功");
//     filename = '';
//     $(this).hide()
//     $(".js_uploadText").show();
// });

//用来获取输入框的值的方法
function getInputVal() {
    //输入框在attrNameVal里面的属性名
    if($("input.type2")) {
        var objectIndex = []; //输入框的attrname
        var objectIndexVal = []; //输入框里面的值
        for(var m = 0; m < $("input.type2").length; m++) {
            objectIndex.push($($("input.type2")[m]).attr("attrname"));
            objectIndexVal.push($($("input.type2")[m]).val());
        }

        for(var k = 0; k < objectIndex.length; k++) {
            attrNameVal[objectIndex[k]] = objectIndexVal[k];
        }
    }
    // console.log("attrNameVal",attrNameVal);
}

//页面倒计时
var value = $(".timet").val() * 1000;

function getLocalTime(nS) {
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
}

//	时间倒计时
//console.log(time)

//					var EndTime = new Date(time);
var NowTime = new Date();
var t = value - NowTime.getTime();
console.log(t)
if(t < 0) {
    $(".time").html("活动已结束")
}
var d = Math.floor(t / 1000 / 60 / 60 / 24);
var h = Math.floor(t / 1000 / 60 / 60 % 24);
var m = Math.floor(t / 1000 / 60 % 60);
var s = Math.floor(t / 1000 % 60);
$(".t_d").html(d + "天");
$(".t_h").html(h + "时");
$(".t_m").html(m + "分");

//删除数组指定值
function removeByValue(arr, val) {
    for(var i = 0; i < arr.length; i++) {
        if(arr[i] == val) {
            arr.splice(i, 1);
            break;
        }
    }
}

//判断一个数组是否在另一个数组中，filter是数组对象的方法
function where(collection, source) {
    return collection.filter(function(item) {
        var index = 0;
        for(var key in source) {
            if(item[key] && source[key] === item[key]) {
                index++;
            }
        }
        return index === Object.keys(source).length;
    });
}

//输入字符限制
$(".proName").each(function() {
    var text = $(this).text();
    //console.log( text.length)
    if(text.length > 14) {
        str = text.substr(0, 14) + '...';
        $(this).text(str)
    }
});
var height1= $(".proImgPart").outerHeight(true);
var height2= $(".proInfo").outerHeight(true);
var height = height1+height2;
$(window).scroll(function() {
    var sTop = $(window).scrollTop();
    if (sTop >= height) {
        $('#content').addClass('fixed');
    } else {
        $('#content').removeClass('fixed');

    }
});

//用户名字显示成1***1；

var reg = /^(.).+(.)$/g;
console.log($(".userName"))
if($(".userName").length>0){
    var userName = $(".userName").html();
    userName = userName.replace(reg, "$1**$2");
    $(".userName").html(userName);
}

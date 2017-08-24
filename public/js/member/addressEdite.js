//点击完成发送
$('.ok').click(function() {

    //	获取值
    var user = $('#user').val();
    var tel = $('#tel').val();
    var id = $('input[name="id"]').val();
    var detail = $('#detail').val();
    var reg1 =   /^1\d{10}$/;
    var a = reg1.test(tel);
    var province = $('.province option:selected').html();
    //console.log(province);
    var city = $('.city option:selected').html();
    var district = $('.district option:selected').html();
    //	验证

    if(!user){
        $('#user').attr('placeholder','请填写完整')
    };
    if(!tel){
        $('#tel').attr('placeholder','请填写完整')
    };
    if(!detail){
        $('#detail').attr('placeholder','请填写完整')
    };

    if(!a){
        $('#tel').val('');
        $('#tel').attr('placeholder','请输入正确手机号')
    }

    var data = {
        user: user,
        id: id,
        tel: tel,
        province: province,
        city: city,
        district: district,
        detail: detail
    };
    console.log(url);
    console.log(data)
    //	发送值
    if(user && tel && detail && a) {
        console.log("true");
        $.ajax({
            type: "post",
            url: url,
            async: true,
            data: {
                name: user,
                id:id,
                tel: tel,
                province: province,
                city: city,
                district: district,
                detail: detail,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(msg) {
                console.log(msg);
                if(msg=="200"){
                    alert("修改成功");
                    setTimeout(function(){
                        var url=window.location.href;
                        console.log(url);
                        url=url.replace(/addressEdite/,'address');
                        window.location.href=url;
                    },1000)
                }
            }
        });
    }else{
//		alert("请填写完整")
    }

})
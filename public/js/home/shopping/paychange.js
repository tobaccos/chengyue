//点击完成发送
$('.ok').click(function() {
console.log(22);
    //	获取值
    var user = $('#user').val();

    var tel = $('#tel').val();
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
	  tel: tel,
	  province: province,
	  city: city,
	  district: district,
	  detail: detail
	  };
//	 console.log(data)
//    console.log(url);
    //	发送值
    if(user && tel&& detail && a) {
        console.log("true");
        $.ajax({
            type: "POST",
            url: url,
            // async: true,
            data:data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(msg) {
                console.log(msg);
                if(msg=="添加成功"){
                    window.location.href=aurl;
                }
            },
			error:function (data) {
				console.log(data);
            }
        });
    }

})
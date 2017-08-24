var oldpwd,pwd,newpwd;
	$(".yuan input").keyup(function(){
//		var sReg = /[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/;
		var oldpwd=$('.oldpwd').val();
    	var pwd=$(".pwd").val();
    	var newpwd=$('#password').val();
    	 if(oldpwd != "" && pwd != "" && newpwd != "" && pwd != "" && pwd== newpwd && pwd.length<20&&pwd.length>=6 ){
        $("#repassword").removeClass("disabled");
    }else {
        $("#repassword").addClass("disabled");
	}
	})
	$(".pwd").blur(function () {
		var pwd=$(".pwd").val();
    if(pwd.length < 6|| pwd.length > 20){
        $(".newpass").html("请输入6-20位");
    }
    else if(6 <= pwd.length && pwd.length <= 20){
        $(".newpass").html("");
	}
});
$("#password").blur(function () {
	var pwd=$(".pwd").val();
    var newpwd=$('#password').val();
    if(pwd!=newpwd){
        $(".repass").html("两次输入不一致");
    }
    else if(pwd==newpwd){
        $(".repass").html("");
	}
});
    $('#repassword').click(function(){
    	var oldpwd=$('.oldpwd').val();
    	var pwd=$(".pwd").val();
    	var newpwd=$('#password').val();
    	var tokens = $("#token").val();

   		if(oldpwd=="" || pwd=="" || newpwd==""){
   			$('.alert p').text("信息不能为空！！！");
   		}
   		else if( pwd!=newpwd){
   			$('.alert p').text("两次输入密码不一致！！！");
   		}
   		else if(pwd.length<6){
   			$('.alert p').text("密码长度不能小于六位！！！");
   		}
   		else{
   			$('.alert p').text("");
//			var href = "{{ url('/login') }}";
   			$.ajax({
                url:url,
                dataType:"json",
                async:true,
				data:{"token":tokens,"email":oldpwd,"password":pwd,"password_confirmation":newpwd},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"post",//请求的方式
                success:function(req){
					if(req == '200')
					{
                        alert("修改成功，请重新登录");
                        setTimeout(function(){
                            window.location.href = url1;
                        },1000)

					}else if(req == '406'){
						alert("邮箱错误,重新输入")
					}
					else if(req == '405'){
						alert("时间超时，请重新发送邮件")
					}else if(req == '404'){
						alert("修改失败")
					}
                },
                error:function(){}//请求出错的处理
            });
   	}
   		
   		
   	$('.oldpwd').val("");
   		$(".pwd").val("");
   		$('#password').val("");
	
   })
 $('#repassword').click(function(){

    	var oldpwd=$('.oldpwd').val();
    	var pwd=$(".pwd").val();
    	var newpwd=$('#password').val();

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
                url:url1,
                dataType:"json",
                async:true,
				data:{"oldpwd":oldpwd,"pwd":pwd,"newpwd":newpwd},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"post",//请求的方式
                success:function(req){
					if(req == '200')
					{
                        alert("修改成功，请重新登录");
                        setTimeout(function(){
                            window.location.href = url;
                        },1000)

					}else{
						alert("原密码不正确,请重新输入")
					}
                },
                error:function(){}//请求出错的处理
            });
   	}
   	    $('.oldpwd').val("");
   		$(".pwd").val("");
   		$('#password').val("");
	  })
 var oldpwd,pwd,newpwd;
	$(".yuan input").keyup(function(){
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

   		if(oldpwd=="" || pwd=="" || newpwd==""){
   			$('.alert p').text("信息不能为空！！！");
   		}
   		else if( pwd!=newpwd){
   			$('.alert p').text("两次输入密码不一致！！！");
   		}
   		else{
   			$('.alert p').text("");
//			var href = "{{ url('/login') }}";
   			$.ajax({
                url:url,
                dataType:"json",
                async:true,
				data:{"oldpwd":oldpwd,"password":pwd,"password_confirmation":newpwd},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"post",//请求的方式
                success:function(req){
                     console.log(req)
					if(req == 200)
					{
                        alert("修改成功");
                        setTimeout(function(){
                            window.location.href = url1;
                        },1000)

					}else if(req == 405){
						alert(" 原密码错误")
						$('.oldpwd').val("");
// 						$(".pwd").val("");
// 						$('#password').val("");
					}
                },
                error:function(){}//请求出错的处理
            });
   	}	
   });
$(".forget").click(function(){
	 $.ajax({
                url:url2,
                dataType:"json",
                async:true,
//				data:,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"post",//请求的方式
                success:function(req){
                    console.log(req)
                    if(req == 200){
                   
                    	$(".kuang").show();   
                    	setTimeout(function(){
                    		$(".kuang").hide();   
                    	},3000)
                    }else if(req == 404){
                    	alert("未绑定邮箱")
                    }
					
                },
                error:function(){}//请求出错的处理
            });

})

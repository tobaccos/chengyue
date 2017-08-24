 $('#repassword').click(function(){

    	
    	var pwd=$(".pwd").val();
    	var newpwd=$('#password').val();
		console.log(pwd)
	 console.log(newpwd)
   		if(pwd=="" || newpwd==""){
   			$('.alert p').text("信息不能为空！！！");
   		}
   		else if( pwd!=newpwd){
   			$('.alert p').text("两次输入密码不一致！！！");
   		}
   		else{
   			$('.alert p').text("");
//			var href = "{{ url('/login') }}";
//    			$.ajax({
//                 url:url,
//                 dataType:"json",
//                 async:true,
// 				data:{"pwd":pwd,"newpwd":newpwd},
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 type:"post",//请求的方式
//                 success:function(req){
// 					if(req == '200')
// 					{
//                         alert("修改成功");
//                         setTimeout(function(){
//                             window.location.href = url1;
//                         },1000)
//
// 					}
//                 },
//                 error:function(){}//请求出错的处理
//             });
   	}
   	$('.oldpwd').val("");
   		$(".pwd").val("");
   		$('#password').val("");
	
   })
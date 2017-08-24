//输入框中删除的显示
$("#email").keyup(function(){
//	alert("123")
	var text = $("#email").val();
	if(text != ""){
		$(".logindel").show();
	}else{
		$(".logindel").hide();
	}
	
});
$(".logindel").click(function(){
		$(this).hide();
		$("#email").val("");
});

$("#password").keyup(function(){
//	alert("123")
	var text = $("#password").val();
	if(text != ""){
		$(".worddel").show();
	}else{
		$(".worddel").hide();
	}
	
});
$(".worddel").click(function(){
		$(this).hide();
		$("#password").val("");
});

//$(".opendel").click(function(){
//	$(this).find("img").
//})
//密码的显示与不显示
$(".open").click(function(){
//	alert("123")
	$(this).css("display","none");
	$(".close").css("display","block");
	$("#password").attr("type","password");
});
$(".close").click(function(){
	$(this).css("display","none");
	$(".open").css("display","block");
	$("#password").attr("type","text");
});

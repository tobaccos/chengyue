//验证的切换
$(".phone").click(function(){
//	alert("123")
	$("#phone").show();
	$("#emailreg").hide();
	$(this).css("border-bottom","4px solid #FE0000")
	$(".email").css("border-bottom","none")
});
$(".email").click(function(){
	$("#emailreg").show();
	$("#phone").hide();
	$(this).css("border-bottom","4px solid #FE0000")
	$(".phone").css("border-bottom","none")
})

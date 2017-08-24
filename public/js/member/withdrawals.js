//充值
$(".btnn").click(function(){
	var num = $(".charges").val();
	var zhi = $("#type").val();
	var arr = [num,zhi]
	$('#data').val(arr);
	console.log(num)
// console.log($('#data').val());
	//发送数据
	 $('#charges').submit();
});

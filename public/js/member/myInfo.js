//申请中
$(".shenqing").click(function(){
	$(".kuang").show();
	$(".now").show();
	setTimeout(function(){
	$(".kuang").hide();
	$(".now").hide();
	},1500)
})
//输入字符限制
	var text = $(".nameInfo").text();
	//console.log( text.length)
	if(text.length > 8) {
		str = text.substr(0, 8) + '...';
		$(".nameInfo").text(str)
	}
var load = $('#img1').val();
console.log(load)
console.log(load.indexOf("http"))
if(load.indexOf("http")>=0){

	$(".phot").attr("src",load);
}
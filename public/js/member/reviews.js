 //五角星选择
var wjxs = "★";
var wjxn = "☆";
$(".pro-info ul li").mousemove(function () {
    $(this).text(wjxs).prevAll().text(wjxs).end().nextAll().text(wjxn)
      }).mouseleave(function () {
      $(".pro-info ul li").text(wjxn);
   	  $(".clicked").text(wjxs).prevAll().text(wjxs).end().nextAll().text(wjxn)
      }).click(function () {
      $(this).addClass("clicked").siblings().removeClass("clicked")
})

$(function() {
	var objUrl;
	var img_html;
	$("#myFile").change(function() {
		var img_div = $(".img_div");
		var filepath = $("input[name='myFile']").val();
		for(var i = 0; i < this.files.length; i++) {
			objUrl += getObjectURL(this.files[i]);
			var currentUrl= getObjectURL(this.files[i]);
			var extStart = filepath.lastIndexOf(".");
			var ext = filepath.substring(extStart, filepath.length).toUpperCase();
			/*
			描述：鉴定每个图片上传尾椎限制
			* */
			if(ext != ".BMP" && ext != ".PNG" && ext != ".GIF" && ext != ".JPG" && ext != ".JPEG") {
				$(".shade").fadeIn(500);
				$(".text_span").text("图片限于bmp,png,gif,jpeg,jpg格式");
				this.value = "";
				$(".img_div").html("");
				return false;
			} else {
				/*
				若规则全部通过则在此提交url到后台数据库
				* */
				img_html = "<div class='isImg'><img src='" + currentUrl + "' onclick='javascript:lookBigImg(this)' style='height: 100%; width: 100%;' /><span class='removeBtn' onclick='javascript:removeImg(this)'>x</span></div>";
				img_div.html(img_html);
			}
		}
		/*
		描述：鉴定每个图片大小总和
		* */
		var file_size = 0;
		var all_size = 0;
		for(j = 0; j < this.files.length; j++) {
			file_size = this.files[j].size;
			all_size = all_size + this.files[j].size;
			var size = all_size / 1024;
			if(size > 105500) {
				$(".shade").fadeIn(500);
//				$(".text_span").text("上传的图片大小不能超过100k！");
				this.value = "";
				$(".img_div").html("");
				return false;
			}
		}
		return true;
	});
	/*
	描述：鉴定每个浏览器上传图片url 目前没有合并到Ie
	* */
	function getObjectURL(file) {
		var url = null;
		if(window.createObjectURL != undefined) { // basic
			url = window.createObjectURL(file);
		} else if(window.URL != undefined) { // mozilla(firefox)
			url = window.URL.createObjectURL(file);
		} else if(window.webkitURL != undefined) { // webkit or chrome
			url = window.webkitURL.createObjectURL(file);
		}
		//console.log(url);
		return url;
	}
});
/*
描述：上传图片附带删除 再次地方可以加上一个ajax进行提交到后台进行删除
* */
function removeImg(r) {
	$(r).parent().remove();
}
/*
描述：上传图片附带放大查看处理
* */
function lookBigImg(b) {
	$(".shadeImg").fadeIn(500);
	$(".showImg").attr("src", $(b).attr("src"))
}
/*
描述：关闭弹出层
* */
function closeShade() {
	$(".shade").fadeOut(500);
}
/*
描述：关闭弹出层
* */
function closeShadeImg() {
	$(".shadeImg").fadeOut(500);
}




	$(".footer button").click(function (event) {
        var content =$('textarea').val();
        var pic = $('#myFile').val();
        console.log(content);
        console.log(pic);
        if(!content && !pic){
            event.preventDefault();

        }
    })

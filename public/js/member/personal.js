$(function() {
	var objUrl;
	var img_html;
	$("#myFile").change(function() {
		var img_div = $(".img_div")
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
				$(".img_div").html("");
				img_html = "<div class='isImg'><img src='" + currentUrl + "' onclick='javascript:lookBigImg(this)' style='height:1.5rem; width:1.5rem;' /></div>";
				img_div.append(img_html);
				var formData = new FormData($("#uploadForm")[0]);
				/*
				 描述：鉴定每个图片大小总和
				 * */
                var file_size = 0;
                var all_size = 0;
                for(j = 0; j < this.files.length; j++) {
                    file_size = this.files[j].size;
                    all_size = all_size + this.files[j].size;

                    var size = all_size / 1024;
                    console.log(size);
                    if(size > 100500) {
                        $(".shade").fadeIn(500);
//				$(".text_span").text("上传的图片大小不能超过100k！");
                        this.value = "";
                        $(".img_div").html("");
                        return false;
                    }else {
                    	alert("上传成功")
                        $.ajax({
                            url:url,
                            dataType:"json",
                            async:true,
                            data:formData,
                            contentType:false,
                            processData:false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            type:"post",//请求的方式
                            success:function(req){
                                 alert("上传成功")
                            },
                            error:function(){}//请求出错的处理
                        });
					}
                }


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
// 邮箱绑定
    $(".vicar").click(function(){
        $(".shadw").show();
        $(".kuang").show();
        $(".sure").click(function(){
        })
        $(".quxiao").click(function(){
            $(".shadw").hide();
            $(".kuang").hide();
        })
    })
 //手机号绑定
  $(".phone").click(function(){
        $(".shadw2").show();
        $(".kuang").show();
        $(".sure").click(function(){
        })
        $(".quxiao").click(function(){
            $(".shadw2").hide();
            $(".kuang").hide();
        })
    })
  //qq号绑定
  $(".qq").click(function(){
        $(".shadw3").show();
        $(".kuang").show();
        $(".sure").click(function(){
        })
        $(".quxiao").click(function(){
            $(".shadw3").hide();
            $(".kuang").hide();
        })
    })
  //用户绑定
   $(".user").click(function(){
        $(".shadw4").show();
        $(".kuang").show();
        $(".sure").click(function(){
        })
        $(".quxiao").click(function(){
            $(".shadw4").hide();
            $(".kuang").hide();
        })
    })
  
   var reg1 =   /^1\d{10}$/;
  $("#myform2").click(function(event){
  	var text1 = $(".phone1").val();
//	console.log(typeof text1);
//	text1=parseInt(text1);
//	console.log(text1);
console.log(reg1.test(text1));
    if(reg1.test(text1)){  
         
    }else{
    	alert("电话格式错误")
        event.preventDefault();  
    }  
}); 
 
 var reg2 =   /^\d{5,10}$/;
  $("#myform3").click(function(){  
  	var text2 = $(".qq1").val();
    if(reg2.test(text2)){  
        
    }else{
    	alert("qq格式错误")
        event.preventDefault();  
    }  
});  
var load = $('#img1').val();

if(load.indexOf("http")>=0){

    $(".phot").attr("src",load);
}
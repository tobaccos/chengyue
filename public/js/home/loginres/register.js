var uName,uEmail,passWord,passwordConfirm;
$("#emailreg input").keyup(function () {
    uName = $("#name").val();
    uEmail = $("#email").val();
    passWord = $("#password").val();
    passwordConfirm = $("#password-confirm").val();

    if(uName != "" && uEmail != "" && passWord != "" && passwordConfirm != "" && 6 <= passWord.length && passWord.length <= 20 && 6 <= uName.length && uName.length <= 20 && passWord == passwordConfirm ){
        $(".regBtn").removeClass("disabled");
    }else {
        $(".regBtn").addClass("disabled");
	}

});

$("#name").blur(function () {
    if(uName.length < 6 || uName.length > 20){
        $(".uNotice").html("请输入6-20位");
    }
    else if(6 <= uName.length && uName.length <= 20){
        $(".uNotice").html("");
	}
});
//如果输入内容为11位并且不包含@，用手机正则验证
//如果包含@用邮箱正则验证
$("#email").blur(function () {
    if(uEmail.indexOf("@") < 0){
        var rePhone = /^1[345789][0-9]{9}$/;
        if(rePhone.test(uEmail)){
            $(".eNotice").html(" ");
        }else{
            $(".eNotice").html("请输入合法手机号");
        }
    }
    if(uEmail.indexOf("@") > 0 ){
       var reEmail = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        if(reEmail.test(uEmail)){
            $(".eNotice").html(" ");
        }else{
            $(".eNotice").html("请输入合法邮箱");
        }
    }

});


$("#password").blur(function () {
    if(passWord.length < 6 || passWord.length > 20){
        $(".pNotice").html("请输入6-20位");
    }
    else if(6 <= passWord.length && passWord.length <= 20){
        $(".pNotice").html("");
    }
});

$("#password-confirm").blur(function () {
    if(passWord != passwordConfirm){
        $(".repNotice").html("两次输入不一致");
    }
    else if(passWord == passwordConfirm){
        $(".repNotice").html("");
	}
});
function delay(){
window.setTimeout(function(){
$(".form-horizontal").submit();
},100000);
return true;
}














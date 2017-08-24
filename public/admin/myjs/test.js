window.onload = function() {
  $("#username").focus()
}
/************************  失焦判断  **********************************/
$("input").blur(function() {
  $(".spa").css("color", "red")
  if($(this).is("#username")) { //姓名判断
    var na = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if($("#username").val() != "") {
      if(!(na.test($("#username").val()))) {
        $(".spa1").text("用户名长度为2-20个字符");
        $(this).css("border", "1px solid red")
        return false;
      } else if(na) {
        $(".spa1").text("");
        return true;
      }
    } else {
      $(".spa1").text('用户名不能为空！');
    }
  }
  if($(this).is("#userphone")) { //手机号判断
    var ph = /^1[3|5|7|8|][0-9]{9}$/;
    if($("#userphone").val() != "") {
      if(!(ph.test($("#userphone").val()))) {
        $(".spa2").text("请输入正确手机号");
        $(this).css("border", "1px solid #BD362F")
        return false;
      } else if(ph) {
        $(".spa2").text("");
        return true;
      }
    } else {
      $(".spa2").text("账户余额不能为空");
    }
  }


  if($(this).is("#useraddress")) { //地址判断
    var ad = /^(?=.*?[\u4E00-\u9FA5])[\dA-Za-z\u4E00-\u9FA5]{8,32}/;
    if($("#useraddress").val() != "") {
      if(!(ad.test($("#useraddress").val()))) {
        $(".spa3").text("请输入正确地址");
        $(this).css("border", "1px solid #BD362F")
        return false;
      } else if(ad) {
        $(".spa3").text("");
        return true;
      }
    } else {
      $(".spa3").text("");
    }
  }

  if($(this).is("#yve")) {
    var yv = /^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d+)$/;
    if($("#yve").val() != "") {
      if(!(yv.test($("#yve").val()))) {
        $(".spa4").text("账户余额不能为负");
        $(this).css("border", "1px solid #BD362F")
        return false;
      } else if(yv) {
        $(".spa4").text("");
        return true;
      }
    } else {
      $(".spa4").text("");
    }
  }

  if($(this).is("#email")) {
    var em =  /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
    if($("#email").val() != "") {
      if(!(em.test($("#email").val()))) {
        $(".spa5").text("请输入正确的邮箱格式");
        $(this).css("border", "1px solid #BD362F")
        return false;
      } else if(em) {
        $(".spa5").text("");
        return true;
      }
    } else {
      $(".spa5").text("");
    }
  }

  if($(this).is("#QQ")) {
    var qq = /^[1-9][0-9]{4,9}$/;
    if($("#QQ").val() != "") {
      if(!(qq.test($("#QQ").val()))) {
        $(".spa6").text("请输入正确的QQ");
        $(this).css("border", "1px solid #BD362F")
        return false;
      } else if(qq) {
        $(".spa6").text("");
        return true;
      }
    } else {
      $(".spa6").text("");
    }
  }


  if($(this).is("#urlll")) {
    var ur = /^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/;
    if($("#urlll").val() != "") {
      if(!(ur.test($("#urlll").val()))) {
        $(".spa7").text("网址必须以http://或者https://开头");
        $(this).css("border", "1px solid #BD362F")
        return false;
      } else if(ur) {
        $(".spa7").text("");
        return true;
      }
    } else {
      $(".spa7").text("");
    }
  }

  if($(this).is("#parname")) { //姓名判断
    var pa = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if($("#parname").val() != "") {
      if(!(pa.test($("#parname").val()))) {
        $(".spa8").text("合作商家名长度为2-20个字符");
        $(this).css("border", "1px solid red")
        return false;
      } else if(pa) {
        $(".spa8").text("");
        return true;
      }
    } else {
      $(".spa8").text('合作商家名不能为空！');
    }
  }

  if($(this).is("#adname")) { //姓名判断
    var an = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if($("#adname").val() != "") {
      if(!(an.test($("#adname").val()))) {
        $(".spa9").text("管理员名长度为2-20个字符");
        $(this).css("border", "1px solid red")
        return false;
      } else if(an) {
        $(".spa9").text("");
        return true;
      }
    } else {
      $(".spa9").text('管理员名不能为空！');
    }
  }

  if($(this).is("#nodename")) { //姓名判断
    var nn = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if($("#nodename").val() != "") {
      if(!(nn.test($("#nodename").val()))) {
        $(".spa11").text("规则名长度为2-20个字符");
        $(this).css("border", "1px solid red")
        return false;
      } else if(nn) {
        $(".spa11").text("");
        return true;
      }
    } else {
      $(".spa11").text('规则名不能为空！');
    }
  }

  if($(this).is("#gname")) { //姓名判断
    var gn = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if($("#gname").val() != "") {
      if(!(gn.test($("#gname").val()))) {
        $(".spa13").text("组名长度为2-20个字符");
        $(this).css("border", "1px solid red")
        return false;
      } else if(gn) {
        $(".spa13").text("");
        return true;
      }
    } else {
      $(".spa13").text('组名不能为空！');
    }
  }

  if($(this).is("#tname")) { //姓名判断
    var tn = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if($("#tname").val() != "") {
      if(!(tn.test($("#tname").val()))) {
        $(".spa14").text("用户类长度为2-20个字符");
        $(this).css("border", "1px solid red")
        return false;
      } else if(tn) {
        $(".spa14").text("");
        return true;
      }
    } else {
      $(".spa14").text('用户类名不能为空！');
    }
  }

  if($(this).is("#pt")) { //姓名判断
    var pt = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;
    if($("#pt").val() != "") {
      if(!(pt.test($("#pt").val()))) {
        $(".spa15").text("开通金额只能为数字且不能为负");
        $(this).css("border", "1px solid red")
        return false;
      } else if(pt) {
        $(".spa15").text("");
        return true;
      }
    } else {
      $(".spa15").text('金额不能为空！');
    }
  }

  if($(this).is("#py")) { //姓名判断
    var py =/^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;
    if($("#pny").val() != "") {
      if(!(py.test($("#py").val()))) {
        $(".spa16").text("开通金额只能为数字且不能为负");
        $(this).css("border", "1px solid red")
        return false;
      } else if(py) {
        $(".spa16").text("");
        return true;
      }
    } else {
      $(".spa16").text('金额不能为空！');
    }
  }

  if($(this).is("#title")) { //姓名判断
    var gn = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if($("#title").val() != "") {
      if(!(gn.test($("#title").val()))) {
        $(".spa17").text("组名长度为2-20个字符");
        $(this).css("border", "1px solid red")
        $("#gsub").attr("disabled", true);
        return false;
      } else if(gn) {
          $("#gsub").removeAttr("disabled");
        $(".spa17").text("");

        return true;
      }
    } else {
      $("#gsub").attr("disabled", true);
      $(".spa17").text('组名不能为空！');
    }
  }


})
/********************** 聚焦提示 ************************/
$("input").focus(function() {
  if($(this).is("#username")) {
    $(".spa1").text("用户名长度为2-20个字符").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#userphone")) {
    $(".spa2").text("11位手机号码").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#useraddress")) {
    $(".spa3").text("最少8个字符（汉字、字母和数字）").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#yve")) {
    $(".spa4").text("账户余额不能为负").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#email")) {
    $(".spa5").text("请输入正确的邮箱格式").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#QQ")) {
    $(".spa6").text("请输入正确的QQ").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#urlll")) {
    $(".spa7").text("请输入正确的网址").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#parname")) {
    $(".spa8").text("合作商家名长度为2-20个字符").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#adname")) {
    $(".spa9").text("管理员名长度为2-20个字符").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#nodename")) {
    $(".spa11").text("规则名长度为2-20个字符").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#gname")) {
    $(".spa13").text("规则名长度为2-20个字符").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#tname")) {
    $(".spa14").text("用户类名长度为2-20个字符").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#pt")) {
    $(".spa15").text("金额只能为数字，不能为负").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#py")) {
    $(".spa16").text("金额只能为数字，不能为负").css("color", "#aaa")
    $(this).css("border", "1px solid #aaa")
  }
  if($(this).is("#title")) {
    $(".spa17").text("组名长度为2-20个字符").css("color", "#aaa")
      $("#gsub").removeAttr("disabled");
    $(this).css("border", "1px solid #aaa")
  }
})
/*********************** 提交验证 ***************************/
$("#sub").click(function() {
  var na = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
  var ph = /^1[3|5|7|8|][0-9]{9}$/; //手机号正则
  // var ad = /^(?=.*?[\u4E00-\u9FA5])[\dA-Za-z\u4E00-\u9FA5]{8,32}/; //地址正则
  // var yv = /^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d+)$/;//余额正则
  var em = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;//邮箱正则
  var qq = /^[1-9][0-9]{4,9}$/;//QQ正则
  if(na.test($("#username").val()) && ph.test($("#userphone").val()) && em.test($("#email").val()) && qq.test($("#QQ").val())) {
    return true;
  }
  else if(($("#userphone").val() == "")&&na.test($("#username").val())&& em.test($("#email").val())){
      return true;
  }
  else if(($("#email").val() == "")&&na.test($("#username").val())&& ph.test($("#userphone").val())){
      return true;
  }
  else {
    if($("#username").val() == "") {
      $(".spa1").text('请填写用户名')
    }
    return false;
  }
})



$("#psub").click(function() {
var ur = /^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/;
  var pa = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
  if(ur.test($("#urlll").val()) && pa.test($("#parname").val())) {
    return true;
  }
  else {
    if($("#urlll").val() == "") {
      $(".spa7").text('请填写网址')
    }
    if($("#parname").val() == "") {
						$(".spa8").text('请填写商家名')
					}
    return false;
  }
})

$("#asub").click(function() {
var em = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;//邮箱正则
  var an = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
  if(em.test($("#email").val()) && an.test($("#adname").val())&&($("#password").val() != "") ) {
    return true;
  }
  else {
    if($("#adname").val() == "") {
      $(".spa9").text('请填写管理员姓名')
    }
    if($("#email").val() == "") {
						$(".spa5").text('请填写管理员邮箱')
					}
          if($("#password").val() == "") {
            $(".spa10").text('请填写管理员密码')
          }
    return false;
  }
})
  $("#nsub").click(function() {
  var nn = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
    if(nn.test($("#nodename").val())) {
      return true;
    }
    else {
      if($("#nodename").val() == "") {
        $(".spa11").text('请填写规则名称')
      }
      if($("#lujing").val() == "") {
  						$(".spa12").text('请填写规则路径')
  					}

      return false;
    }
})
$("#gsub").click(function() {
var gn = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
  if(gn.test($("#gname").val())) {
    $("#gsub").removeAttr("disabled");
    var name = $('#title').val();
    var ids =new Array();
    $("input[type='checkbox']:checked").each(function(i){
        ids.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url:cheUrl,
        data:{"ids":ids,name:name},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(msg){
            layer.msg(msg, {time:5000,icon: 0});
            // $('body').html(data);
            setTimeout("location.reload();",1000);
//						window.location.reload();
        },
        error:function(data){

        }
    });
    return true;

  }
  else {
    if($("#gname").val() == "") {
      $(".spa17").text('请填写组名称')
    }
    return false;
  }
})

$("#tsub").click(function() {
var tn = /^(([\u4e00-\uFA29])|(\d)|([A-Za-z])){2,20}$/;
var pt = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;
var py = /^(?!0+(?:\.0+)?$)(?:[1-9]\d*|0)(?:\.\d{1,2})?$/;
  if(tn.test($("#tname").val())&&pt.test($("#pt").val())&&py.test($("#py").val()) ) {
    return true;
  }
  else {
    if($("#tname").val() == "") {
      $(".spa14").text('请填写用户类名称')
    }
    if($("#pt").val() == "") {
      $(".spa15").text('请填写开通金额')
    }
    if($("#py").val() == "") {
      $(".spa16").text('请填写开通金额')
    }
    return false;
  }
})

/**
 * Created by Administrator on 2017/5/19.
 */
$(function () {
    function check(objVal,objP,label) {
        if($.trim(objVal) ==""){
            $("#btn").attr("disabled", true);
            $(objP).html(label+"不能为空，请重新填写！");
        }else{
            $(objP).html("");
        }
        // console.log("src",$('#art_thumb_img').attr('src'));
        // console.log("fileWarp",$('.fileWarp  ul').html());
        btnCheck();
    }

    function  btnCheck() {
      if($("proname").val()=="" || $("time").val()=="" ||  $("time").val()=="" || $('#art_thumb_img').attr('src')=="" || $('.fileWarp ul').html()=="" || $('.attrhidden').html()==""
          || $('.attrlists').html()==""){
          $("#btn").attr("disabled", true);
      }
      else{
          $("#btn").removeAttr("disabled");
      }
    }
    btnCheck();
    //产品名称
    $('#proname').change(function () {
        check($('#proname').val(),$('.nameInfo'),$('.nameLabel').text());
    });
   //产品利率
    $('#prorate').change(function () {
        check($('#prorate').val(),$('.prorateInfo'),$('.rateLabel').text());
    });
})
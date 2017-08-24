/**
 * Created by Administrator on 2017/5/19.
 */
// 表单验证
   $(function () {
       $('#setbtn').click(function () {
           if($('#myname').val()==""){
               layer.alert("网站名称不能为空");
               return false;
           }
           if($('#myemail').val()==""){
               layer.alert("网站邮箱不能为空");
               return false;
           } else{
               if(webemail.test($('#myemail').val())==false){
                   layer.alert("网站邮箱格式不正确，请重新填写！");
                   $('#myemail').val("");
                   return false;
               }
           }
           if($('#mycom').val()==""){
               layer.alert("网站域名不能为空");
               return false;
           }else{
               if( mycom.test($('#mycom').val())==false){
                   layer.alert("域名格式不正确，请重新填写！");
                   $('#mycom').val("");
                   return false;
               }
           }
           if($('#mykey').val()==""){
               layer.alert("网站关键字不能为空");
               return false;
           }
           if($('#myreg').val()==""){
               layer.alert("网站描述不能为空");
               return false;
           }
           if($('#mycop').val()==""){
               layer.alert("公司名称不能为空");
               return false;
           }
           if($('#mytel').val()==""){
               layer.alert("公司手机不能为空");
               return false;
           }
           else{
               if(mytel.test($('#mytel').val())==false){
                   layer.alert("手机号格式不正确，请重新填写！");
                   $('#mytel').val("");
                   return false;
               }
           }
           if($('#mytel1').val()==""){
               layer.alert("公司电话不能为空");
               return false;
           }
           else{
               if(mytel1.test($('#mytel1').val())==false){
                   layer.alert("电话格式不正确，请重新填写！");
                   $('#mytel1').val("");
                   return false;
               }
           }
           if($('#myaddress').val()==""){
               layer.alert("公司地址不能为空");
               return false;
           }
           if($('#mycopyright').val()==""){
               layer.alert("公司版权不能为空");
               return false;
           }
           if($('#myreg1').val()==""){
               layer.alert("注册声明不能为空");
               return false;
           }
           if($('#myqq').val()==""){
               layer.alert("QQ客服不能为空");
               return false;
           }
           else{
               if(myqq.test($('#myqq').val())==false){
                   layer.alert("QQ格式不正确，请重新填写！");
                   $('#myqq').val("");
                   return false;
               }
           }
           if($('#mypro').val()==""){
               layer.alert("虚拟币比例不能为空");
               return false;
           }
           if($('#myrebate').val()==""){
               layer.alert("返利总利率不能为空");
               return false;
           }
           $.ajax({
               type: 'post',
               url: formUrl,
               data: $("form").serialize(),
               success: function(data) {
                   console.log("success");
                   layer.msg(data.msg);
               }
           });
       })
   })

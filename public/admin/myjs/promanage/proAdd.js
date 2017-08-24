//        图片上传
$(function() {
    $('#mysel_sele').attr('placeholder',"请选择或输入属性组合...");
    $('#file_upload').uploadify({
        //
        'auto'			  : true,
        'method'   		  : 'post',
        'multi'   		  : true,
        'progressData'    : 'all',
        'queueSizeLimit'  : 10,
        'uploadLimit'     : 5,
        'fileSizeLimit'   : '2048KB',
        'fileTypeDesc' 	  : 'Image Files',
        'fileTypeExts'    : '*.jpeg; *.jpg; *.png; *.gif',
        'queueID'         : 'fileQueue',
        'buttonText' : '图片上传',
        'formData'     : {
            'timestamp' :time,
            '_token'     :token
        },
        'swf'      : swf,
        'uploader' :uploader,
        'onUploadSuccess' : function(file, data, response) {
//                    $(' fieldset').css("border","1px solid #ccc");
            $(' #product .submenu').css('display','block');
            $('#product>a').css('color','#5999D0');
            $(".fileWarp ul").append(SetImgContent(data));
            SetUploadFile();
        }
    });
});
//单个图片上传
$(function() {
    var date=new Date().getTime();
    $('#file_upload1').uploadify({
        'buttonText' : '图片上传',
        'fileSizeLimit'   : '2048KB',
        'formData'     : {
            'timestamp' :date,
            '_token'     :token,
        },
        'swf'      :swf,
        'uploader' : uploader,
        'onUploadSuccess' : function(file, data, response) {
            var obj=eval('('+data+')');
            $('#art_thumb_img').attr('src',obj.url);
            $('input[name=thumbing]').val(obj.name);
        }
    });
});
//添加属性组合名称
function addBig() {
    layer.open({
            type: 1,
            area: ['420px', '400px'], //宽高
            content: '<div class="myform"><form method="post" action='+formUrl+' id="form_attr_arr"><div class="adds">*组合名称：<input type="text" id="comattr" name="com_name" placeholder="请输入属性组合名称" maxlength="20"></input>' +
    '&nbsp;&nbsp;<button type="button"  class="btn btn-xs btn-info addattr" onclick="addattr()">添加属性</button></div><br/><br/><br/><br/><button type="button"  class="btn btn-lg btn-info subbtn" onclick="subbtn()">提交</button></form></div>'
});
    addattr();
    $('.attrhidden').html('');
    $('.attrlists').html('');
}
//添加属性组合名称成功后添加到下拉列表框
function subbtn(){
    var str="",attrname='';
    $.ajax({
        type : "post",
        url : url,
        data : $('#form_attr_arr').serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(dates){
            str= $('#comattr').val();
            attrname=$('.attrname input[type="text"]');
            if(str=="" && attrname==""){
                layer.alert('请填写属性组合名称');
            }else{
                $("#mysel_hidden_select").append("<option value='" + dates + "'  selected>"+str+"</option>");
                // console.log('dd',$("#mysel_hidden_select").html());
                $('#mysel_sele').val(str);
                selChange();
                layer.closeAll();
            }
        },

    });
}
//删除单个属性文本框
function delAttr(del) {
    $(del).parent().remove();
}
//添加属性组合名称弹出框内的单个属性文本框
function addattr(){
    $('.adds').append('<div class="attrname">*属性名：<input type="text" name="attr[]" placeholder="请输入属性名称" maxlength="20"/><select name="attr_type[]"><option value="0">单选</option><option value="1">多选</option><option value="2">自定义</option></select>' +
        '<button  type="button"  class="btn btn-xs btn-info delattr" onclick="delAttr(this)" >删除</button></div>')
}
//属性组合内容
//输入选择插件
$('#mysel').editableSelect({
           effects: 'slide',
           isFilter:true,
           onSelect: function (element) {
               $('.shift-info').attr('data-val',element.val());
               selChange();//生成内容
           },
       })
//文本框获得焦点时清空文本框内容
$('#mysel_sele').focus(function () {
    $('#mysel_sele').val('');
})
//输入错误属性组合时清空属性组合名称和属性组合内容
$('#mysel_sele').blur(function () {
   var textVal= $('#mysel_sele').val();
   var flag=false;
    $("#mysel_hidden_select  option").each(function(){  //遍历所有option
        var txt = $(this).text();   //获取option值
        if( textVal==txt){
            flag=true;
        }
    })
    if(flag==false){
        layer.alert("没有此属性组合，请重新输入");
        $('.attrhidden').html('');
        $('.attrlists').html('');
        $('#mysel_sele').val('');
    }
})
function  selChange(){
    //获得文本框当前相对应option的值
    var myselVal;
    if(typeof($("#mysel_sele").attr("data-val"))=="undefined"){
        myselVal=$("#mysel_hidden_select  option:selected").val();
    }else{
      myselVal= $('#mysel_sele').attr('data-val');
    }

    $.ajax({
        url:selUrl + '/' + myselVal,
        type:'get',
        success:function(data) {
            var htmlstr = "<form>";
            for (var i = 0; i < data.length; i++) {
                if(data[i]['status'] == 0){
                    htmlstr += '<div class="form-group comcon"><label class="col-sm-2 control-label no-padding-right prolabel " ismore="singlelabel"> ' + data[i]['name'] +
                        '</label> <div class="col-sm-6 moreattr"> <input type="text" name="' + data[i]['id'] + '"  required  maxlength="20" class="col-xs-10 col-sm-6 protext moretext" ismore="singleinput" />  </div> </div>'
                }else if(data[i]['status'] == 1){
                    htmlstr += '<div class="form-group comcon"><label class="col-sm-2 control-label no-padding-right prolabel " ismore="morelabel"> ' + data[i]['name'] +
                        '</label> <div class="col-sm-6 moreattr"> <input type="text" name="' + data[i]['id'] + '"    maxlength="10"   class="col-xs-10 col-sm-6 protext moretext" ismore="moreinput" />  <input type="number" name="' + data[i]['id'] + '"   placeholder="请输入此属性的价格" min="0.00"  max="999999" class="col-xs-10 col-sm-6 protext" ismore="moreinput" onchange="var val=parseFloat(this.value).toFixed(2);if(val<0){val=0.00};this.value=val" value="0.00"/> </div> </div>'
                }else if(data[i]['status'] == 2){
                    htmlstr += '<div class="form-group comcon"><label class="col-sm-2 control-label no-padding-right prolabel "  ismore="unde" > ' + data[i]['name'] +
                        '</label> <div class="col-sm-6 moreattr userinput"> <span name="' + data[i]['id'] + '" ismore="undespan" >此为用户输入选项</span></div> </div>'

                }

            }
            htmlstr +='<div class="form-group comcon"><label class="col-sm-2 control-label no-padding-right prolabel"  ismore="singlelabel">利率</label> <div class="col-sm-6 moreattr"> <input type="number" required name="rate"  class="col-xs-10 col-sm-6 protext" ismore="singleinput" value="0.001"  min="0.001" step="0.001" onchange="var val=parseFloat(this.value).toFixed(3);if(val>=1 |val<=0){val=0.001};this.value=val" /> </div> </div>' +
                '<div class="form-group comcon"><label class="col-sm-2 control-label no-padding-right prolabel"  ismore="singlelabel">单位</label> <div class="col-sm-6 moreattr"> <input type="text" required maxlength="5" name="unit"  class="col-xs-10 col-sm-6 protext" ismore="singleinput" /> </div> </div> ' +
                '<div class="form-group comcon"><label class="col-sm-2 control-label no-padding-right prolabel"  ismore="singlelabel">价格</label> <div class="col-sm-6 moreattr"> <input min="0.00" max="999999"  placeholder="请输入价格" type="number" required name="price" id="price" class="col-xs-10 col-sm-6 protext" ismore="singleinput" onchange="var val=parseFloat(this.value).toFixed(2);if(val<0){val=0.00};this.value=val"/> </div> </div>' +
                '  <div class="form-group comcon"><div class="col-sm-6 control-label no-padding-right"><button type="button" class="btn btn-xs btn-info " onclick="attrComBluk(this)">添加属性组</button></div></div></form>';
            $('.attrhidden').html(htmlstr);
            $('.attrlists').html('');

        },

    });

}

//生成属性组合块
function  attrComBluk(add){
    //判断价格不能为空
    if($('#price').val()==""){
        layer.alert("价格不能为空，请输入！");
        return false;
    }
    //生成id
    var liststotal=$('.attrlist').length;
    var listid="list"+liststotal;
    //单个属性
    var labelsArray=new Array;
    var inputsArray=new Array;
    var inputNameArray=new Array;
    var labels=$('.comcon label[ismore ="singlelabel"]');
    var inputs=$('.comcon input[ismore ="singleinput"]');
    var len=labels.length;
    //生成数组
    for(var i=0;i<len;i++){
        labelsArray.push($(labels[i]).text());
        // console.log()
    }
    for(var i=0;i<len;i++){
        inputsArray.push($(inputs[i]).val());
        inputNameArray.push($(inputs[i]).attr('name'));
    }
    // 多个属性
    var morelaArray=new Array;
    var moreinArray=new Array;
    var moreinNameArray=new Array;
    var morela=$('.comcon label[ismore="morelabel"]');
    var morein=$('.comcon input[ismore="moreinput"]');
//            console.log(morein);
    for(var i=0;i<morela.length;i++){
        morelaArray.push($(morela[i]).text());
    }
    for(var i=0;i<morein.length;i++){
        moreinArray.push($(morein[i]).val());
        moreinNameArray.push($(morein[i]).attr('name'));
    }
    //自定义属性
    var undeArray=new Array;
    var  undeNameArray=new Array;
    var unde=$('.comcon label[ismore="unde"]');
    var undespan=$('.comcon span[ismore="undespan"]');
    for(var i=0;i<unde.length;i++){
        undeArray.push($(unde[i]).text());
    }
    for(var i=0;i<undespan.length;i++){
        undeNameArray.push($(undespan[i]).attr('name'));
    }
    $.ajax({
        type:'post',
        data:'1',
        dataType:'json',
        success:function(data) {
            var jsn = data;
            var htmlstr = "";

        },
        error:function() {
            //颜色标志
            // var bgstr='<div  id="bgFlag"><div  id="bgShow"><span class="bgColor"></span><span class="bgColor"></span><span class="bgColor"></span><span class="bgColor"></span><span class="bgColor"></span></div></div><input type="hidden" id="color" name="color[]">';
            var bgstr='<div  class="bgFlag" onclick="bgFlag(this)"><div  class="bgShow"><span class="bgColor" onclick="bg(this)"></span><span class="bgColor" onclick="bg(this)"></span><span class="bgColor" onclick="bg(this)"></span><span class="bgColor" onclick="bg(this)"></span><span class="bgColor" onclick="bg(this)"></span></div></div><input type="hidden"  name="colorCh[]">';
            var htmlstr ='<div class="attrlist" id="'+listid+'">'+bgstr;
            //自定义属性的添加
            for (var i = 0; i <unde.length; i++) {
                htmlstr += '<label class="key"  ismore="undekey">'+undeArray[i]+'</label> <input type="hidden" name="attr['+undeNameArray[i]+'][name]" value="'+undeArray[i]+'" ><input type="hidden" name="attr['+undeNameArray[i]+'][type]" value="2" ><input type="hidden" name="attr['+undeNameArray[i]+'][value][]" value="1" >用户自定义<br/><br/>';
            }
            //多个属性的添加
            for (var i = 0; i <morela.length; i++) {
                htmlstr += '<label class="key" ismore="morekey">'+morelaArray[i]+'</label> <input type="hidden" readonly="readonly" ismore="morevalue" name="attr['+moreinNameArray[i]+'][name]" value=" '+morelaArray[i]+'"><input type="hidden" readonly="readonly" ismore="morevalue" name="attr['+moreinNameArray[i]+'][type]" value="1"><input type="text"  class="value" onkeyup ="textCheck(this)"   readonly="readonly" ismore="morevalue" name="attr['+moreinNameArray[i]+'][value][name][]" value=" '+moreinArray[i*2]+'"> <input type="number" class="value" readonly="readonly" onkeyup ="textCheck(this)"   ismore="morevalue" name="attr['+moreinNameArray[i]+'][value][value][]" value="'+moreinArray[i*2+1]+'"><br/><br/>';
            }
            //单个属性的添加
            for (var i = 0; i <len; i++) {
                if(labelsArray[i]=='利率'){
                    htmlstr += '<label class="key" ismore="singlekey">'+labelsArray[i]+'</label> <input type="hidden" ismore="singlevalue" name="attr['+inputNameArray[i]+'][name]" readonly="readonly"  value=" '+labelsArray[i]+'"/><input class="validate" type="hidden" ismore="singlevalue" name="attr['+inputNameArray[i]+'][type]" readonly="readonly"  value="0"/><input type="text" required maxlength="20"  ismore="singlevalue" name="attr['+inputNameArray[i]+'][value][]" readonly="readonly" class="value"  value=" '+inputsArray[i]+'" onchange="var val=parseFloat(this.value).toFixed(3);if(val>=1 |val<=0){val=0.001};this.value=val"/><br/><br/>';

                }else if(labelsArray[i]=='价格'){
                    htmlstr += '<label class="key" ismore="singlekey">'+labelsArray[i]+'</label> <input type="hidden" ismore="singlevalue" name="attr['+inputNameArray[i]+'][name]" readonly="readonly"  value=" '+labelsArray[i]+'"/><input class="validate" type="hidden" ismore="singlevalue" name="attr['+inputNameArray[i]+'][type]" readonly="readonly"  value="0"/><input type="number" ismore="singlevalue" name="attr['+inputNameArray[i]+'][value][]" readonly="readonly" class="value"  value="'+inputsArray[i]+'" required onchange="var val=parseFloat(this.value).toFixed(2);if(val<0){val=0.00};this.value=val"/><br/><br/>';

                }else{

                    htmlstr += '<label class="key" ismore="singlekey">'+labelsArray[i]+'</label> <input type="hidden" ismore="singlevalue" name="attr['+inputNameArray[i]+'][name]" readonly="readonly"  value=" '+labelsArray[i]+'"/><input class="validate" type="hidden" ismore="singlevalue" name="attr['+inputNameArray[i]+'][type]" readonly="readonly"  value="0"/><input type="text" ismore="singlevalue" name="attr['+inputNameArray[i]+'][value][]" readonly="readonly" class="value"  value=" '+inputsArray[i]+'" onkeyup ="textCheck(this)" maxlength="20"/><br/><br/>';
                }
            }
            htmlstr+=' <span class="btnspan btnmod" onclick="modifyAttr(this)">修改</span> <span class="btnspan btncopy" onclick="attrComCopy(this)">复制</span> <span class="btnspan btndel" onclick="delAttr(this)">删除</span></div>';
            $('.attrlists').append(htmlstr);

        }

    });
}

//颜色标志选择
function bgFlag(that) {
    if($(that).find('span').css('display')=='none'){
        $(that).find('span').css('display','inline-block');
    }
    else{
        $(that).find('span').css('display','none');
    }
}
function bg(that) {
    var color=$(that).css('background-color');
    $(that).parent().parent().css('background',color);
    $(that).parent().parent().next([type='hidden']).val(color);
}

//文本验证
function  textCheck(that) {
    if($(that).val().length>25){
        $(that).val("");
    }
}
//复制属性组合块
function attrComCopy(copy){
    var liststotal=$('.attrlist[id *="copy"]').length;
    var copyid='copy'+liststotal;
    $(copy).parent().clone(true).attr("id",copyid).appendTo($(".attrlists"));

}
//修改属性组合块
function  modifyAttr(mod){
    if(flage==true){
        $(mod).text('保存');
        $(mod).parent().children('input').removeAttr('readonly').css('border','1px solid #ddddddd').css('background','#dddddd');
        flage=false;
    }
    else{
        $(mod).text('修改');
        $(mod).parent().children('input').attr('readonly','readonly').css('border','1px solid #ddddddd').css('background','#fff');
        flage=true;
    }

}
//
$('#submitBtn').click(function () {
    $.ajax({
        type: 'post',
        url:fd,
        data: $("#addForm").serialize(),
        success: function(data) {
            if(data.state==1){
                layer.msg(data.msg);
                window.location.href=data.url;
            }
            else if(data.state==0){
                layer.msg(data.msg);
            }

        }
    });
})
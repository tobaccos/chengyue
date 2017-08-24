/**
 * Created by Administrator on 2017/5/19.
 */
/**
 * Created by Administrator on 2017/5/19.
 */
function SetImgContent(data){
    var obj=eval('('+data+')');
    if(obj.state == '1'){
        var sLi = "";
        sLi += '<li class="img">';
        sLi += '<img src="' + obj.url + '" width="100" onerror="this.src=\'/uploadify/nopic.png\'">';
        sLi += '<input type="hidden" name="fileurl_tmp[]" value="' + obj.name + '">';
        sLi += '<a href="javascript:void(0);" onclick="delpic(this)">删除</a>';
        sLi += '</li>';
        return sLi;
    }else{
        layer.alert(obj.text, {icon: 2});
        return;
    }
}
function SetUploadFile(){
    $("ul li").each(function(l_i){
        $(this).attr("id", "li_" + l_i);
    })
    $("ul li a").each(function(a_i){
        $(this).attr("rel", "li_" + a_i);
    }).click(function(){
        $("#" + this.rel).remove();
    })
}
function delpic(that){
    $(that).parent().remove();
}
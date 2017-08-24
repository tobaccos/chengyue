/**
 * Created by Administrator on 2017/5/22.
 */
//checkbox 全选/取消全选
var isCheckAll = false;
function swapCheck() {
    if (isCheckAll) {
        $("input[type='checkbox']").each(function() {
            this.checked = false;
        });
        isCheckAll = false;
    } else {
        $("input[type='checkbox']").each(function() {
            this.checked = true;
        });
        isCheckAll = true;
    }
}
//单个删除
function getid(id) {
    // $('.del').click(function(){
    // var id=$('.del').val();
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消']
    }, function(){
        $.ajax({
            type: "GET",
            url: delUrl,
            data:{"id":id } ,
            success: function(msg){
                layer.msg(msg, {icon: 0});
                // $('body').html(data);
                setTimeout("location.reload();",1000);
            },
            error:function(data){

            }
        });
    }, function(){
    });
}
$(document).ready(function(){//页面加载完之后，自动执行该方法
    setTimeout(function(){$("#info").hide();},2000);//2秒后执行该方法
});

$(".cha1").click(function() {
    var idd = $(this).attr('rel');
    $.ajax({
        type: "Get",
        url:showUrl,
        data:{"id":idd},
        success: function(msg){
            $("#Modal1 .modal-body").text(msg);

        },
        error:function(){

        }
    });
})
//多个删除
$(function(){
    $("#del").click(function() {
        var ids =new Array();
        $("input[type='checkbox']:checked").each(function() {
            ids.push($(this).val());
        })
        $.ajax({
            type: "GET",
            url: delsUrl,
            data:{"ids":ids} ,
            success: function(msg){
                layer.msg(msg, {time:5000,icon: 2});
                setTimeout("location.reload();",2000);
            },
            error:function(data){

            }
        });
    });
});

/**
 * Created by Administrator on 2017/5/22.
 */
// 时间日期
jQuery(function($) {
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })
    //show datepicker when clicking on the icon
        .next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
//or change it into a date range picker
    $('.input-daterange').datepicker({autoclose:true});
    //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
    $('input[name=date-range-picker]').daterangepicker({
        'applyClass' : 'btn-sm btn-success',
        'cancelClass' : 'btn-sm btn-default',
        locale: {
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
        }
    })
        .prev().on(ace.click_event, function(){
        $(this).next().focus();
    });
    $('#timepicker1').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false,
        disableFocus: true,
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down'
        }
    }).on('focus', function() {
        $('#timepicker1').timepicker('showWidget');
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
        //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-arrows ',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        }
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
});
//多选框
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
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消']
    }, function(){
        $.ajax({
            type: "GET",
            url: delUrl,
            data:{"id":id } ,
            success: function(msg){
                layer.msg(msg, {time:5000,icon: 0});
                // $('body').html(data);
                setTimeout("location.reload();",1000);
            },
            error:function(data){

            }
        });
    }, function(){
    });
}

function resid(id) {
    layer.confirm('确定要重置密码吗？', {
        btn: ['确定','取消']
    }, function(){
        $.ajax({
            type: "GET",
            url:resUrl ,
            data:{"id":id } ,
            success: function(msg){
                layer.msg(msg, {time:5000,icon: 0});
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

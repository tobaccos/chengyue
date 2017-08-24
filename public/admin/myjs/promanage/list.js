/**
 * Created by Administrator on 2017/5/19.
 */
// 排序箭头
$(function () {
    var url = location.href ;
    //产品名称
    if(url.search("desc") != -1 && url.search("id") != -1){
        $("#proname i img").attr("src",ascUrl);
    }else if(url.search("asc") != -1 && url.search("id") != -1){
        $("#proname i img").attr("src",descUrl);
    }
    else{
        $("#proname i img").attr("src",ascUrl);
    }
    //更新日期
    if(url.search("desc") != -1 && url.search("updated_at") != -1){
        $("#dateorder i img").attr("src",ascUrl);
    }else if(url.search("asc") != -1 && url.search("updated_at") != -1){
        $("#dateorder i img").attr("src",descUrl);
    }
    else{
        $("#dateorder i img").attr("src",ascUrl);
    }
    //销量
    if(url.search("desc") != -1 && url.search("volume") != -1){
        $("#volume i img").attr("src",ascUrl);
    }else if(url.search("asc") != -1 && url.search("volume") != -1){
        $("#volume i img").attr("src",descUrl);
    }
    else{
        $("#volume i img").attr("src",ascUrl);
    }
    //收藏
    if(url.search("desc") != -1 && url.search("id") != -1){
        $("#collection i img").attr("src",ascUrl);
    }else if(url.search("asc") != -1 && url.search("collection") != -1){
        $("#collection i img").attr("src",descUrl);
    }
    else{
        $("#collection i img").attr("src",ascUrl);
    }
})
// 排序
function dataOrder(that,url){
    if( $(that).children('i').children('img').attr("src")==descUrl){
        $(that).children('i').children('img').attr("src",ascUrl);
        window.location.href=orderUrl + "?order=" + url +"_desc";
        console.log("desc");
    }else{
        $(that).children('i').children('img').attr("src",descUrl);
        window.location.href=orderUrl + "?order=" + url +"_asc";
        console.log("asc");
    }
}
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
jQuery(function($) {
  $('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true
   })
   .next().on(ace.click_event, function(){
     $(this).prev().focus();
   });
   $('.input-daterange').datepicker({autoclose:true});
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


 $('#nidd').click(function(){
     var start = $("#start").val();
     var end = $("#end").val();
     var address1 = $("#province2").val();
     var address2 = $("#city2").val();
     var address3 = $("#district2").val();
     $.ajax({
         type: "GET",
         url: "{{ url('admin/order/viewList') }}",
         data: {start:start,end:end,address1:address1,address2:address2,address3:address3},
         success:function(e){
             console.log(e);

             $(".table tr:not(:first)").html("");
             var item;
             $.each(e, function(i, data) {
                 $.each(data,function(j,value){
                     var timme=getLocalTime(value.created_at);

                     if(value.state==0){
                         var stt='未支付';
                     }
                     else if(value.state==1){
                         var stt='支付完成待处理';
                     }
                     else if(value.state==2){
                         var stt='已发货';
                     }
                     else if(value.state==3){
                         var stt='配送中';
                     }else{
                         var stt = "已签收";
                     }
                     item = "<tr><td>"+value['serialnumber']+"</td><td>"+value["uname"]+"</td><td>"+timme+"</td><td>"+value['pname']+"</td><td>"+value['productnum']+"</td><td>"+value['favorableprice']+"</td><td>"+stt+"</td><td>"+value['log_money']+"</td><td>"+value['allprice']+"</td><td>"+value['spaid']+"</td></tr>";
                     $('.table').append(item);
                 })
             });
         },
         error:function(){
             console.log("error");
         }
     })
if($('#tab').css('display')=='none'){
       $('#tab').css('display','');
   }
   else{
       $('#tab').css('display','none');
   }
})


function today(){
     var today=new Date();
     var h=today.getFullYear();
     var m=today.getMonth()+1;
     var d=today.getDate();
     var o=today.getHours();
     var i=today.getMinutes();
     if (m >= 1 && m<= 9) {
         m = "0" + m;
     }
     if (d >= 0 && d <= 9) {
         d = "0" + d;
     }
     if (o >= 1 && o<= 9) {
         o = "0" + o;
     }
     if (i >= 0 && i <= 9) {
         i = "0" + i;
     }
     return h+""+m+""+d+""+o+""+i;
   }
 timccc.onclick=function(){
   document.getElementById("timcc").value = today();
   }

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



$(function(){
   $("#del").click(function() {
     // alert(121);
   var ids =new Array();
       $("input[type='checkbox']:checked").each(function() {
           // n = $(this).val();
           // alert(n);
           ids.push($(this).val());
         });
  //  alert(ids);
   $.ajax({
     type: "GET",
     url: delUrl,
     data:{"ids":ids} ,
     success: function(msg){
       layer.msg(msg, {time:5000,icon: 0});
       // $('body').html(data);
       setTimeout("location.reload();",2000);
   //						window.location.reload();
     },
     error:function(data){

     }
   });
   });
   });



   function getid(id) {
   	// $('.del').click(function(){
   	// var id=$('.del').val();
   	layer.confirm('确定要删除吗？', {
   		btn: ['确定','取消']
   	}, function(){
   		$.ajax({
   			type: "GET",
   			url:delsUrl,
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




   function libid(id) {
   	// $('.del').click(function(){
   	// var id=$('.del').val();
   	layer.confirm('确定要出库吗？', {
   		btn: ['确定','取消']
   	}, function(){
   		$.ajax({
   			type: "GET",
   			url:libUrl ,
   			data:{"id":id } ,
   			success: function(msg){
   				layer.msg(msg, {time:5000,icon: 0});
   				// $('body').html(data);
   				setTimeout("location.reload();",1000);
   				//						window.location.reload();
   			},
   			error:function(data){

   			}
   		});
   	}, function(){

   	});
   }


   $(function(){
   	// Set up the number formatting.
   	$('.num').number( true, 2 );
   });

   $(document).ready(function() {
   	$(".cha").click(function() {
   		var id = $(this).attr('rel');
   		var url =updUrl;
   		$("#Modal .modal-body > form").attr("action", url );
   		$(".id").attr("value",id );
   		$(".id").attr("value", id);
   		// $("#Modal").modal();
   	});
   });

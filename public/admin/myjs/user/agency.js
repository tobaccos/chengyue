$(document).ready(function() {
  $(".cha").click(function() {
    var id = $(this).attr('rel');
    $("#Modal .modal-body > form").attr("action", "reject/" + id);
    $("#Modal").modal();
  });
});

$(".cha1").click(function() {
   var idd = $(this).attr('rel');
 $.ajax({
        type: "Get",
        url:showUrl ,
        data:{"id":idd},
        success: function(msg){
         $("#Modal1 .modal-body").text(msg);

       },
        error:function(){

        }
    });
})


$(".cal").click(function() {
   var ids = $(this).attr('rel');
 $.ajax({
        type: "Get",
        url:sucUrl +ids,
        success: function(msg){
          layer.msg(msg, {
            time: 3000
          });
          // layer.msg(msg, {time:7000,icon: 1});
        setTimeout("window.location.reload()",3000);

       },
        error:function(){

        }
    });
})

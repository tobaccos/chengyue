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

function getid(id) {
  // $('.del').click(function(){
  // var id=$('.del').val();
  layer.confirm('确定要删除吗？', {
    btn: ['确定','取消']
  }, function(){
    $.ajax({
      type: "GET",
      url:geUrl,
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


$(document).ready(function() {
  $(".cha").click(function() {
    var id = $(this).attr('rel');
    $("#Modal .modal-body > form").attr("action", "reject/" + id);
    // $("#Modal").modal();
  });
});


$(".cha1").click(function() {
   var idd = $(this).attr('rel');
  //  alert(11);
 $.ajax({
        type: "Get",
        url:cha1Url ,
        data:{"id":idd},
        success: function(msg){
         $("#Modal1 .modal-body").text(msg);

       },
        error:function(){

        }
    });
})


$(function(){
$("#del").click(function() {
  // alert(121);
var ids =new Array();
    $("input[type='checkbox']:checked").each(function() {
        // n = $(this).val();
        // alert(n);
        ids.push($(this).val());
      });
// alert(ids);
$.ajax({
  type: "GET",
  url:delUrl ,
  data:{"ids":ids} ,
  success: function(msg){
    layer.msg(msg, {time:115000,icon: 0});
    // $('body').html(data);
    setTimeout("location.reload();",112000);
//						window.location.reload();
  },
  error:function(data){

  }
});
});
});

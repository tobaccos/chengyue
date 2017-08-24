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

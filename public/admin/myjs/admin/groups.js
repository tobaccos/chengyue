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


$(".cha").click(function() {
var id = $(this).attr('rel');
	$.ajax({
        type: "Get",
        url:showUrl,
        data:{"id":id},
        success: function(msg){
					$("#Modal .modal-body").text(msg);

				},
        error:function(){

        }
    });
})


function getid(id) {
  layer.confirm('确定要删除分组吗？', {
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

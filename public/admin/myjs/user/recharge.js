// 删除充值记录
$(".delBtnPo").click(function() {
	$.ajax({
		url:delUrl ,
		type: 'post',
		headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success:function(data){
      layer.msg(data);
      setTimeout("location.reload();",2000);

    },
    error:function(){

    },
	})

});
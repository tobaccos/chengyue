$(document).ready(function(){
	ckeck();//页面加载完之后，自动执行该方法
});

function ckeck() {
  // for(var i=0;i<fxks.length;i++){
  //     var f = fxks[i];
  //     if(f.value==8){
  //         f.checked=true;
  //     }
  // }
	$("#classify div button").click(function() {
		if (chec) {
			$(this).next().children().each(function() {
				$(this).children()[0].checked=true;
			});
			$(this).text("取消全选");
			chec = false;
		}
		else {
			$(this).next().children().each(function() {
				$(this).children()[0].checked=false;
			});
			$(this).text("全选");
			chec = true;
		}
	});
}


$("#gsub").click(function() {
    var name = $('#title').val();
    var id = $('#id').val();
    var ids =new Array();
	$("input[type='checkbox']:checked").each(function(i){
        ids.push($(this).val());
        // console.log(ids);
	});
    $.ajax({
        type: "POST",
        url: che1Url,
        data:{"ids":ids,name:name,id:id} ,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(msg){
            layer.msg(msg, {time:5000,icon: 0});
            // $('body').html(data);
            setTimeout("location.reload();",1000);
//						window.location.reload();
        },
        error:function(data){

        }
    });
})

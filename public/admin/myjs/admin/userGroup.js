$(document).ready(function(){
	ckeck();
});
function ckeck() {
	var chec = true;
	$(".checkAll").click(function() {
		if (chec) {
			$(this).next().children().each(function(index,item) {
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
    var ids =new Array();
	$("input[type='checkbox']:checked").each(function(i){
        ids.push($(this).val());
	});
    $.ajax({
        type: "POST",
        url: che2Url,
        data:{"ids":ids,name:name} ,
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

$("#update").click(function (){
	$.ajax({
		type: "GET",
		url:reUrl ,
		success: function(msg){

				layer.msg(msg, {time:5000,icon: 0});
				setTimeout("location.reload();",1000);


		},
		error:function(data){

		}
	});
})

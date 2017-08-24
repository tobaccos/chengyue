//发送时间
$(".imglogo1").click(function() {

	var date1 = $('#date1').val();
	console.log(date1);
	var date2 = $('#date1').val();
//	document.getElementsByClassName('form1')[0].submit();

});


$(".pos").children('img').click(function() {
	var id = $(this).parent().siblings('input').val();
	var target=$(this);
	console.log(id);
	$.ajax({
		type: "post",
		url: url,
		async: true,
		data: {
			id: id
		},
		 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

		success:function(data) {
			console.log(data);
			console.log(target.parents('tr'));
			if(data == 200) {
				target.parents('tr').remove();

			}

		}
	});

})
$(".imglogo1").click(function() {
	var date1 = $('#date1').val();
//	console.log(date1);
	var date2 = $('#date2').val();
	var datef = new Date(date1);
	var datel = new Date(date2);
	console.log(datel)
	console.log(date2)
	if(datef>datel){
		alert("终止时间应该大于开始时间")
		$('#date2').val("");
	}else if(date1 == ""||date2 ==""){
		alert("请选择时间在查询")
	}
	else{
		 $.ajax({
		type: "POST",
		url: url1,
		data: {
			ftime : date1,
			ltime :date2
		},
		dataType: "json",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success: function(msg) {
//			console.log(msg);
			if(msg!=""){
				$('.common1 tbody').html(msg);	
			}else{
				$('.common1 tbody').html("暂无数据");	
			}
			$(".pos").children('img').click(function() {
			var id = $(this).parent().siblings('input').val();
			var target=$(this);
		    console.log(id);
	$.ajax({
		type: "post",
		url: url,
		async: true,
		data: {
			id: id
		},
		 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

		success:function(data) {
			console.log(data);
			console.log(target.parents('tr'));
			if(data == 200) {
				target.parents('tr').remove();

			}

		}
	});

})
		},
		error: function(data) {
			console.log('bbbbb');
		}
	});
	}
});

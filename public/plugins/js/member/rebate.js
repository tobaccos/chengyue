//发送时间
$(".imglogo1").click(function() {

	var date1 = $('#date1').val();
	console.log(date1);
	var date2 = $('#date1').val();
	document.getElementsByClassName('form1')[0].submit();

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
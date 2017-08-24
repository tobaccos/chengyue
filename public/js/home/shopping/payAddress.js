$('.defaultImg').click(function() {

	var url = $(this).attr('src');
	var uaddress_id = $(this).attr('data-id');
	var urlfalse = url.replace(/true.png/, 'false.png');
	var urltrue = url.replace(/false.png/, 'true.png');
	console.log(uaddress_id);
	//	取消其他
	$(".defaultImg").attr('src', urlfalse);
	//自己变亮
	var url2 = /false/.test(url) ? url.replace(/false.png/, 'true.png') : url.replace(/true.png/, 'false.png');
	$(this).attr('src',urltrue);

	//	发送ajax来传递默认
	
	
	if($(this).attr('src')==urltrue){
			$.ajax({
		type: "post",
		url:urldefault,
		async: true,
		data: {
			id: uaddress_id,
			state: '1'
		},
		            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		success: function(data) {
				if(data == 200)
				{
					window.location.href = burl;
				}
		}
	});
	}


});

//修改地址
$('.imgleft').click(function() {

	var uaddress_id = $(this).parent().siblings('.defaultImg').attr('data-id');

	console.log(uaddress_id);

	//	发送ajax来修改
	$.ajax({
		type: "post",
		url: urledite,
		async: false,
		data: {
			id: uaddress_id,
			
		},
		            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		success: function(data) {
			var url = window.location.href;
			console.log(url);
			url = url.replace(/payAddress/, 'addressEdite');
			window.location.href = url;
		}
	});

});

//删除地址
$('.delimg').click(function() {

    var uaddress_id = $(this).siblings('input').val();
var that=$(this);
	console.log(uaddress_id);


	$.ajax({
		type: "post",
		url: urldel,
		async: true,
		data: {
			id: uaddress_id,
		},
		            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		success: function(data) {

			that.parents('div.addressList').remove()
		}
	});

});
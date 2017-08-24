//选择类
var urlfalse = $(".choose").children('img').attr('src');
var urltrue = urlfalse.replace(/false.png/, 'true.png');
//console.log(urltrue);
$('.choose').click(function() {
	var url = $(this).children('img').attr('src');
	var url2 = /false/.test(url) ? urltrue : urlfalse;
	$(this).children('img').attr('src', url2);
})
//取消收藏
$(".del").click(function() {
	$(".choose img").each(function() {
		var haha = $(this).attr("src").indexOf("true") > 0;

		console.log(haha);

		var that = $(this);
		var ids = [];
		if($(this).attr("src").indexOf("true") > 0) {
			var id = $(this).parent().prev('input').val();
			ids.push(id);
			console.log(id);
			$.ajax({
				type: "POST",
				url: urlAll,
				data: {
					id: ids
				},
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
				success: function(msg) {
					console.log(msg);
					that.parent().parent().remove();
					window.location.reload();

				},
				error: function(data) {
					console.log('bbbbb');
				}
			});
		}
	})
})
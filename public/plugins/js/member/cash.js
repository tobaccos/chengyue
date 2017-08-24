//全部提现
var total = $('.total').html();
total=parseFloat(total);
total=total.toFixed(2);
//console.log(total);
$('.all').click(function() {

	$('#cash').val(total);

})

//获取提现金额
var cash;
$('#cash').change(function() {
	cash = $('#cash').val();
	cash = parseFloat(cash);
	cash = cash.toFixed(2);
	cash = cash > total ? total : cash;
//	console.log(cash);
	$('#cash').val(cash);

//	console.log(cash);
//	cash = $('#cash').val();
})


//var cash=$('#cash').val(cash);
//点击提现
$('.ok').click(function() {
    var tixian = $('#cash1').val();//提现方式
    var number = $('#cash2').val();//提现账号
	if(total>0) {
		console.log(11);
		// console.log(tixian);
		// console.log(number);
		$.ajax({

			url: url,
			type: 'post',
			data: {
				cash: cash,
                bank_name: tixian,
                bank_num: number
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(msg) {
				console.log(msg);
				if(msg == '提现成功') {
					setTimeout(function() {
						var url = window.location.href;
						console.log(url);
						url = url.replace(/cash/, 'myInfo');
						window.location.href = url;
					}, 2000)
				}

			}
		});
	}

})
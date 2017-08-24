//全部提现,去除零头
var total = $('.total').html();
//看看
if(total >= 100){
    var totalYu=total%100;
    total = total-totalYu;
    total = parseFloat(total);
    total = total.toFixed(2);
}

console.log(total);
$('.all').click(function() {
	$('#cash').val(total);

});

//获取提现金额
var cash;
$('#cash').change(function() {
	cash = $('#cash').val();
    cash = parseFloat(cash);
	cash = cash.toFixed(2);
	cash = cash > total ? total : cash;
	$('#cash').val(cash);
});


//var cash=$('#cash').val(cash);
//点击提现
$('.ok').click(function() {
    if(cash<100){
        alert("余额低于最低提现额度！");
        return false;
    }
    if(cash >= 100){
        if( cash % 100 != 0 ){
            //如果true 证明 cash不能被100整除
            $('#cash').val("");
            alert("请输入100的倍数哦");
        }else{
            //能被100整除
            var tixian = $('#type').val();//提现方式
            var number = $('#cash2').val();//提现账号
            if(total>0) {

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
                        if(msg == '406'){
                            alert('余额低于最低提现额度！');
                            return false;
                        }
                        if(msg == '提现成功') {
                            alert('提现成功');
                            setTimeout(function() {
                                var url = window.location.href;
                                console.log(url);
                                url = url.replace(/cash/, 'myInfo');
                                window.location.href = url;
                            }, 1000)
                        }

                    }
                });
            }
        }
    }


})
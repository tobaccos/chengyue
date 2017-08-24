//分类全选或全不选
var urlfalse = $(".choseItem").children('img').attr('src');
var urltrue = urlfalse.replace(/false.png/, 'true.png');
//console.log(urltrue);
$(".choseItem").click(function() {
	var url = $(this).children('img').attr('src');
	var url2 = /false/.test(url) ? urltrue : urlfalse;
	$(this).children('img').attr('src', url2);
	$(this).parent().siblings().find('.chose img').attr('src', url2)
})

//全选或全不选
$(".all").click(function() {
	var url = $(this).children('img').attr('src');
	var url2 = /false/.test(url) ? urltrue : urlfalse;
	$(this).children('img').attr('src', url2);
	$('.choseItem').children('img').attr('src', url2)
	$('.choseItem').parent().siblings().find('.chose img').attr('src', url2)
})
//单击其中的一个
$('.chose').click(function() {
	var url = $(this).children('img').attr('src');
	var url2 = /false/.test(url) ? urltrue : urlfalse;
	$(this).children('img').attr('src', url2);

	var haha = $(this).parent().parent().parent('.con-info').find(".chose");
	//	console.log(haha)
	//	var url = $(this).children('img').attr('src');
	var urls = [];
	haha.each(function() {
		urls.push($(this).children().attr('src'));
	});
	if(/false/.test(urls)) {
		//		console.log(111);
		//		console.log($(this).parent().parent().parent('.con-info').siblings('.con-head'));
		$(this).parent().parent().parent('.con-info').siblings('.con-head').children().children('img').attr('src', urlfalse)
	} else {
		//		console.log(222);

		$(this).parent().parent().parent('.con-info').siblings('.con-head').children().children('img').attr('src', urltrue)

	};

})

//购物车商品数量加减
$('.add').click(function() {
	var num = $(this).siblings('input').val();
	$(this).siblings('input').val(parseInt(num) + 1)
})
//购物车商品数量减
$('.reduce').click(function() {
	var num = parseInt($(this).siblings('input').val());
	num = num > 1 ? num - 1 : 0
	$(this).siblings('input').val(num);

})

//计算总的价格
$(".goods").click(
	function() {
		var prices = 0;
		var imgs = $(this).find('.chose').children('img');
		//	console.log(imgs);
		//选中的数量
		var productNum = 0;
		var priceOrigins = 0;
		imgs.each(function() {
			var url = $(this).attr('src');
			if(url == urltrue) {
				var num = parseInt($(this).parent().siblings('.info').find('input').val());
				//			console.log(num);
				var uPrice = parseFloat($(this).parent().siblings('.price').find('.price_real').html().substring(1));
				//			console.log(uPrice);
				var total = num * uPrice;
				console.log($(this).parents('div'));
				var priceOrigin = parseFloat($(this).parent().siblings('.price').find('.price_origin').html().substring(1));
				priceOrigins += num * priceOrigin - total;
				priceOrigins = parseFloat(priceOrigins.toFixed(2));
				console.log(priceOrigins);
				prices += total;
				prices = parseFloat(prices.toFixed(2));

				productNum++;

			}
		})
		$('.total').html('¥' + prices);
		$('.save').html('为您节省¥' + priceOrigins);
		$('.product_num').html('(' + productNum + ")");

	}
);

//删除本产品
$('.del').click(function() {

	//发送ajax
	var id = $(this).attr("data-id");
	var that = $(this);
	console.log(id);

	$.ajax({
		type: "post",
		url: delurl,
		async: true,
		data: {
			id: id
		},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success: function(msg) {
			console.log(msg)
			var num = that.parent().parent('li').siblings().length;
console.log("hhhhhhhhh"+num);
			if(num > 0) {
				that.parent().parent('li').remove();

			} else {
				that.parents('div.content').remove()
			}
		}
	});

})

//去结算
$('.balance').click(function(event) {
//	event.stopPropagation();
	//获取所有的图片
	var imgs = $('.goods ul li').find('img');
	console.log(imgs);

	var datas = [];
	imgs.each(function(index, item) {
	
		if($(item).attr('src')==urltrue) {
			var data = {};
		
		var attrNameVal=$(item).parent().siblings('#attrNameVal').val();
		var price1=$(item).parent().siblings('#price1').val();
		if($(item).parent().siblings('#selfAttrObject')){
            var selfAttrObject=$(item).parent().siblings('#selfAttrObject').val();
            data['selfAttrObject'] = selfAttrObject;
		}

		var proId=$(item).parent().siblings('#proId').val();
		var type_umber=$(item).parent().siblings('#type_umber').val();
		var mum = $(item).parents('li').children('.info').find('input').val();
		
		var pro_name=$(item).parent().siblings('#pro_name').val();
		var pro_type=$(item).parent().siblings('#pro_type').val();
		var type_id=$(item).parent().siblings('#type_id').val();
		var del_id=$(item).parent().siblings('#del_id').val();




			data['del_id'] = del_id;
			data['type_id'] = type_id;
			data['pro_type'] = pro_type;
			data['pro_name'] = pro_name;
			data['mum'] = mum;
			data['proId'] = proId;
			data['typeNumber'] = type_umber;
			data['price1'] = price1;
			data['selfAttrObject'] = selfAttrObject;
			data['attrNameVal'] = attrNameVal;
			data= JSON.stringify(data);
//			console.log(data);
			datas.push(data)

			

		};

	})
	$('#data').val(datas);
//console.log($('#data').val());
	//发送数据

	 $('#jiesuan').submit();
	
	/*$.ajax({
		type: "post",
		url: buyurl,
		async: true,
		data: {
			data: datas
		},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success: function(msg) {
			console.log(msg);
			alert(msg);
			setTimeout(function() {
				var url = window.location.href;
				console.log(url);
				url = url.replace(/shopCart/, 'order');
				window.location.href = url;
			}, 2000)
		}

	})*/

})
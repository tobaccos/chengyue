var lists = $(".proItemList");
for(var i = 0; i < lists.length; i++) {
	//	(function(i) {

	var time = $(lists[i]).find("input").attr("value") * 1000;
	//				console.log(time);
	$d = $(lists[i]).find(".t_d");
	$h = $(lists[i]).find(".t_h");
	$m = $(lists[i]).find(".t_m");
	$time = $(lists[i]).find(".time");
	//				console.log($h);
	var NowTime = new Date();
	var t = time - NowTime.getTime();
	console.log(t);
	//		var t1 = String(t);
	//		     		if(t1.indexOf("-1") != 0){
	//		     			$(".time").html("活动已结束")
	//		     		}
	if(t < 0) {
		$time.html("活动已结束")
	}
	var d = Math.floor(t / 1000 / 60 / 60 / 24);
	var h = Math.floor(t / 1000 / 60 / 60 % 24);
	var m = Math.floor(t / 1000 / 60 % 60);
	var s = Math.floor(t / 1000 % 60);
	$d.html(d + "天");
	$h.html(h + "时");
	$m.html(m + "分");
	//     	    $s.html(s + "秒");
	//	})(i)

};

//排序的点击事件
//var checkSortValue = []; //已选分类
var ids = [];
//ids=type_id;
$(".orderItem li").click(function() {
	$(this).addClass("choosed").siblings().removeClass("choosed");
	//排序
	var sortType = $(this).attr('value');
	var searchWrod = $('.search').val();
	if(!$(this).hasClass('sortCheck')) {
		$(".checkModel").hide();
		$(".overLay").hide();
		$.ajax({
			type: "POST",
			url: urlAll,
			data: {
				type_id: ids,
				sortType: sortType,
				searchWrod: searchWrod,
				minPrice: minPriceInput,
				maxPrice: maxPriceInput
			},
			dataType: "json",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			success: function(msg) {
				if(msg != "") {
					$('.proItem').html('');

					//              function getLocalTime(nS) {
					//                  return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
					//              }
					//			var time = getLocalTime(msg[1].updated_at);
					//          console.log(time);
					//遍历添加数据
					for(var i in msg) {
						(function(i) {
							var str = "";
							str += '<li class="proItemList">';
							str += '<a class="proImg" href=' + url1 + '><img src="' + imgPath + msg[i].thumbing + '"></a>';
							str += '<a class="proName" href="javascript:;">' + msg[i].name + '</a>';
							str += '<span class="proPrice">' + msg[i].min + '</span>';
							if(msg[i].end_time != "") {
								var index_t = 'time' + i;
								str += '<div class="' + index_t + ' time">';
								var index_d = 't_d' + i;
								var index_h = 't_h' + i;
								var index_m = 't_m' + i;
								str += '<span class="' + index_d + '">00天</span>';
								str += '<span class="' + index_h + '">00时</span>';
								str += '<span class="' + index_m + '">00分</span>';
								str += '</div>';

							} else {
								str += '</li>';
							}

							//          	console.log(str);
							$('.proItem').append(str);
							var time = msg[i].end_time * 1000;
							//					var time = getLocalTime(msg[i].end_time).replace(/-/g,"/");
							//	时间倒计时
							//					          	console.log(time)

							var EndTime = new Date(time);
							var NowTime = new Date();
							var t = time - NowTime.getTime();
							console.log(t)
							if(t < 0) {
								$("." + index_t).html("活动已结束")
							}
							var d = Math.floor(t / 1000 / 60 / 60 / 24);
							var h = Math.floor(t / 1000 / 60 / 60 % 24);
							var m = Math.floor(t / 1000 / 60 % 60);
							var s = Math.floor(t / 1000 % 60);
							$("." + index_d).html(d + "天");
							$("." + index_h).html(h + "时");
							$("." + index_m).html(m + "分");
							//     			$("."+index_s).html(s + "秒");

							// 				console.log(timer);

						})(i);

					}
				} else {
					str = "<img class='nomore' src=" + url2 + " style='width: 100%;'/>";
					$('.proItem').html(str);
					//将排序禁止点击
//					$(".orderItem li").css("pointer-events", "none");
				}

			},
			error: function(data) {
				console.log('bbbbb');
			}
		});
	}

});
var words = [];
//搜索查询
$('.searchBtn').click(function() {
	$("#keywords").hide();
	words.shift();
	var searchWrod = $('.search').val();
	words.push(searchWrod);
	//	if(checkSortValue.length > 0) {
	//		type_id = checkSortValue;
	//	}
	$.ajax({
		type: "POST",
		url: urlAll,
		data: {
			searchWrod: searchWrod,
			//			type_id: type_id,
			//			minPrice: minPriceInput,
			//			maxPrice: maxPriceInput
		},
		dataType: "json",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		success: function(msg) {
			if(msg != "") {
				$('.proItem').html('');

				//              function getLocalTime(nS) {
				//                  return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
				//              }
				//			var time = getLocalTime(msg[1].updated_at);
				//          console.log(time);
				//遍历添加数据
				for(var i in msg) {
					(function(i) {
						var str = "";
						str += '<li class="proItemList">';
						str += '<a class="proImg" href=' + url1 + '><img src="' + imgPath + msg[i].thumbing + '"></a>';
						str += '<a class="proName" href="javascript:;">' + msg[i].name + '</a>';
						str += '<span class="proPrice">' + msg[i].min + '</span>';
						if(msg[i].end_time != "") {
							var index_t = 'time' + i;
							str += '<div class="' + index_t + ' time">';
							var index_d = 't_d' + i;
							var index_h = 't_h' + i;
							var index_m = 't_m' + i;
							str += '<span class="' + index_d + '">00天</span>';
							str += '<span class="' + index_h + '">00时</span>';
							str += '<span class="' + index_m + '">00分</span>';
							str += '</div>';

						} else {
							str += '</li>';
						}

						//          	console.log(str);
						$('.proItem').append(str);
						var time = msg[i].end_time * 1000;
						//					var time = getLocalTime(msg[i].end_time).replace(/-/g,"/");
						//	时间倒计时
						//					          	console.log(time)

						var EndTime = new Date(time);
						var NowTime = new Date();
						var t = time - NowTime.getTime();
						console.log(t)
						if(t < 0) {
							$("." + index_t).html("活动已结束")
						}
						var d = Math.floor(t / 1000 / 60 / 60 / 24);
						var h = Math.floor(t / 1000 / 60 / 60 % 24);
						var m = Math.floor(t / 1000 / 60 % 60);
						var s = Math.floor(t / 1000 % 60);
						$("." + index_d).html(d + "天");
						$("." + index_h).html(h + "时");
						$("." + index_m).html(m + "分");
						//     			$("."+index_s).html(s + "秒");

						// 				console.log(timer);

					})(i);

				}
			} else {
				str = "<img class='nomore' src=" + url2 + " style='width: 100%;'/>";
				$('.proItem').html(str);
				//将排序禁止点击
//				$(".orderItem li").css("pointer-events", "none");
			}

		},
		error: function(data) {
			console.log('bbbbb');
		}
	});
});
//查询词显示
$(".search").keyup(function() {
	if(words.length > 0) {
		$("#keywords").html("<li>" + words[0] + "</li>").show();

	}

});
$(".search").blur(function() {
	$("#keywords").hide()
})

$("#keywords").click(function() {
	$(".search").val($(this).text());
	$(this).hide();
})

//点击筛选，筛选弹出框弹出
$(".sortCheck").click(function() {
	$(".checkModel").show();
	$(".overLay").show();
	$(".minPriceInput").val('');
	$(".maxPriceInput").val('');
	$('.orderSelected').html('');
	ids = [];
	objs = [];

});

//选择筛选弹出框的分类

$(".sortItem li").click(function() {
	if(!$(this).hasClass("sortChoose")) {
		$(this).addClass("sortChoose");

	} else {
		$(this).removeClass("sortChoose");
	};
	var objss = [];
	var idss = [];
	$('.sortItem li').each(function() {
		if($(this).hasClass('sortChoose')) {
			var obj = {};
			obj['id'] = $(this).val();
			obj['text'] = $(this).text();
			objss.push(obj);
			idss.push($(this).val());
		}
	});

	ids = idss;
	objs = objss;
});

//点击弹出框的确定按钮时
var minPriceInput = '';
var maxPriceInput = '';
$(".checkSure").click(function() {
	$('.orderSelected').css('max-height', '0.635rem');
	//输入的最低价钱
	minPriceInput = $(".minPriceInput").val();
	//输入的最高价钱
	maxPriceInput = $(".maxPriceInput").val();

	$.ajax({
		type: "POST",
		url: urlAll,
		data: {
			type_id: ids,
			minPrice: minPriceInput,
			maxPrice: maxPriceInput
		},
		dataType: "json",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		success: function(msg) {
						var timer = null;
			clearInterval(timer);
			$('.proItem').html('');
			console.log(msg);
			if(msg != "") {
				//			          console.log(time);
				for(var i in msg) {
					(function(i) {
						var str = "";
						str += '<li class="proItemList">';
						str += '<a class="proImg" href=' + url1 + '><img src="' + imgPath + msg[i].thumbing + '"></a>';
						str += '<a class="proName" href="javascript:;">' + msg[i].name + '</a>';
						str += '<span class="proPrice">' + msg[i].min + '</span>';
						if(msg[i].end_time != "") {
							var index_t = 'time' + i;
							str += '<div class="' + index_t + ' time">';
							var index_d = 't_d' + i;
							var index_h = 't_h' + i;
							var index_m = 't_m' + i;
							str += '<span class="' + index_d + '">00天</span>';
							str += '<span class="' + index_h + '">00时</span>';
							str += '<span class="' + index_m + '">00分</span>';
							str += '</div>';

						} else {
							str += '</li>';
						}

						//          	console.log(str);
						$('.proItem').append(str);
						var time = msg[i].end_time * 1000;
						//					var time = getLocalTime(msg[i].end_time).replace(/-/g,"/");
						//	时间倒计时
						console.log(time)

						var EndTime = new Date(time);
						var NowTime = new Date();
						var t = time - NowTime.getTime();
						//					     			console.log(t)
						if(t < 0) {
							$("." + index_t).html("活动已结束")
						}

						var d = Math.floor(t / 1000 / 60 / 60 / 24);
						var h = Math.floor(t / 1000 / 60 / 60 % 24);
						var m = Math.floor(t / 1000 / 60 % 60);
						var s = Math.floor(t / 1000 % 60);
						$("." + index_d).html(d + "天");
						$("." + index_h).html(h + "时");
						$("." + index_m).html(m + "分");
						//     			$("."+index_m).html(s + "秒");

					})(i)
				};

			}  else {
				str = "<img class='nomore' src='../../../images/base/nomore.png' style='width: 100%;'/>";
				$('.proItem').html(str);
				//将排序禁止点击
				//				$(".orderItem li").css("pointer-events", "none");
			};
			//选中的筛选条件
			var orderCont = '<div class="orderCont"></div>';
			$('.orderSelected').append(orderCont);
			objs.forEach(function(item) {
				var htmls = '<span class="selects" data-id="' + item.id + '" >' + item.text + '<img src="' + urlClose + '"></span>';
				console.log("htmls", htmls);
				$('.orderCont').append(htmls)
			});
			var prices = '';
			console.log(minPriceInput);
			if(minPriceInput && maxPriceInput) {
				console.log(11111);
				prices = '<span class="selects prices">价格区间:' + minPriceInput + "-" + maxPriceInput + '<img src="' + urlClose + '"></span>';
				$('.orderCont').append(prices)

			};
			if(minPriceInput && !maxPriceInput) {
				prices = '<span class="selects prices">最低价格:' + minPriceInput + '<img src="' + urlClose + '"></span>';
				$('.orderCont').append(prices)

			};
			if(!minPriceInput && maxPriceInput) {
				prices = '<span class="selects prices">最高价格:' + maxPriceInput + '<img src="' + urlClose + '"></span>';
				$('.orderCont').append(prices)

			};

			if(objs.length > 0 || prices) {

				var shows = '<em class="shows">展开</em>';
				var clear = '<em class="clear">清空</em>';
				$('.orderSelected').append(shows);
				$('.orderSelected').append(clear);
			};
			$(".shows").click(function() {
				$('.orderSelected').css('max-height', 'none')
			});
			$('.proItem').on('touchstart', function() {
				$('.orderSelected').css('max-height', '0.635rem')
			})

			$('.sortItem li').each(function(index, item) {
				//				console.log(item);
				if($(item).hasClass('sortChoose')) {
					$(item).removeClass('sortChoose');
				}
			});
			$('.selects').click(function() {
				var ids = [];
				$(this).remove();
				var siblings = $('span.selects');
				//				console.log(siblings);
				if(siblings.length == 0) {
					$('.clear').remove();
					location.reload();
				};
				siblings.each(function() {
					ids.push($(this).attr('data-id'))
				});
				if($(this).hasClass('prices')) {
					minPriceInput = '';
					maxPriceInput = '';
					console.log(222);
					$.ajax({
						type: "POST",
						url: urlAll,
						data: {
							type_id: ids,

						},
						dataType: "json",
						headers: {
							'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
						},
						success: function(msg) {
								var timer = null;
						clearInterval(timer);
						$('.proItem').html('');
						console.log(msg);
						if(msg != "") {
							//			          console.log(time);
							for(var i in msg) {
								(function(i) {
									var str = "";
									str += '<li class="proItemList">';
									str += '<a class="proImg" href=' + url1 + '><img src="' + imgPath + msg[i].thumbing + '"></a>';
									str += '<a class="proName" href="javascript:;">' + msg[i].name + '</a>';
									str += '<span class="proPrice">' + msg[i].min + '</span>';
									if(msg[i].end_time != "") {
										var index_t = 'time' + i;
										str += '<div class="' + index_t + ' time">';
										var index_d = 't_d' + i;
										var index_h = 't_h' + i;
										var index_m = 't_m' + i;
										str += '<span class="' + index_d + '">00天</span>';
										str += '<span class="' + index_h + '">00时</span>';
										str += '<span class="' + index_m + '">00分</span>';
										str += '</div>';

									} else {
										str += '</li>';
									}

									//          	console.log(str);
									$('.proItem').append(str);
									var time = msg[i].end_time * 1000;
									//					var time = getLocalTime(msg[i].end_time).replace(/-/g,"/");
									//	时间倒计时
									console.log(time)

									var EndTime = new Date(time);
									var NowTime = new Date();
									var t = time - NowTime.getTime();
									//					     			console.log(t)
									if(t < 0) {
										$("." + index_t).html("活动已结束")
									}

									var d = Math.floor(t / 1000 / 60 / 60 / 24);
									var h = Math.floor(t / 1000 / 60 / 60 % 24);
									var m = Math.floor(t / 1000 / 60 % 60);
									var s = Math.floor(t / 1000 % 60);
									$("." + index_d).html(d + "天");
									$("." + index_h).html(h + "时");
									$("." + index_m).html(m + "分");
									//     			$("."+index_m).html(s + "秒");

								})(i)
							};

						} else {
								str = "<img class='nomore' src='../../../images/base/nomore.png' style='width: 100%;'/>";
								$('.proItem').html(str);
								//将排序禁止点击
								//							$(".orderItem li").css("pointer-events", "none");
							};
						}
					});
				} else {
					$.ajax({
						type: "POST",
						url: urlAll,
						data: {
							type_id: ids,
							minPrice: minPriceInput,
							maxPrice: maxPriceInput
						},
						dataType: "json",
						headers: {
							'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
						},
						success: function(msg) {
							var timer = null;
						clearInterval(timer);
						$('.proItem').html('');
						console.log(msg);
						if(msg != "") {
							//			          console.log(time);
							for(var i in msg) {
								(function(i) {
									var str = "";
									str += '<li class="proItemList">';
									str += '<a class="proImg" href=' + url1 + '><img src="' + imgPath + msg[i].thumbing + '"></a>';
									str += '<a class="proName" href="javascript:;">' + msg[i].name + '</a>';
									str += '<span class="proPrice">' + msg[i].min + '</span>';
									if(msg[i].end_time != "") {
										var index_t = 'time' + i;
										str += '<div class="' + index_t + ' time">';
										var index_d = 't_d' + i;
										var index_h = 't_h' + i;
										var index_m = 't_m' + i;
										str += '<span class="' + index_d + '">00天</span>';
										str += '<span class="' + index_h + '">00时</span>';
										str += '<span class="' + index_m + '">00分</span>';
										str += '</div>';

									} else {
										str += '</li>';
									}

									//          	console.log(str);
									$('.proItem').append(str);
									var time = msg[i].end_time * 1000;
									//					var time = getLocalTime(msg[i].end_time).replace(/-/g,"/");
									//	时间倒计时
									console.log(time)

									var EndTime = new Date(time);
									var NowTime = new Date();
									var t = time - NowTime.getTime();
									//					     			console.log(t)
									if(t < 0) {
										$("." + index_t).html("活动已结束")
									}

									var d = Math.floor(t / 1000 / 60 / 60 / 24);
									var h = Math.floor(t / 1000 / 60 / 60 % 24);
									var m = Math.floor(t / 1000 / 60 % 60);
									var s = Math.floor(t / 1000 % 60);
									$("." + index_d).html(d + "天");
									$("." + index_h).html(h + "时");
									$("." + index_m).html(m + "分");
									//     			$("."+index_m).html(s + "秒");

								})(i)
							};

						}else {
								str = "<img class='nomore' src='../../../images/base/nomore.png' style='width: 100%;'/>";
								$('.proItem').html(str);
								//将排序禁止点击
								//							$(".orderItem li").css("pointer-events", "none");
							};
						}
					});
				}

			});

			//	清空
			$('.clear').click(function() {
				//				ids=type_id;
				minPriceInput = '';
				maxPriceInput = '';
				$(".selects").remove();
				$(this).remove();
				location.reload();
				

//				$.ajax({
//					type: "POST",
//					url: urlAll,
//					data: {
//						//						type_id: ids,
//						minPrice: minPriceInput,
//						maxPrice: maxPriceInput
//					},
//					dataType: "json",
//					headers: {
//						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//					},
//					success: function(msg) {
//							if(msg != "") {
//				$('.proItem').html('');
//
//				//              function getLocalTime(nS) {
//				//                  return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
//				//              }
//				//			var time = getLocalTime(msg[1].updated_at);
//				//          console.log(time);
//				//遍历添加数据
//				for(var i in msg) {
//					(function(i) {
//						var str = "";
//						str += '<li class="proItemList">';
//						str += '<a class="proImg" href=' + url1 + '><img src="' + imgPath + msg[i].thumbing + '"></a>';
//						str += '<a class="proName" href="javascript:;">' + msg[i].name + '</a>';
//						str += '<span class="proPrice">' + msg[i].min + '</span>';
//						if(msg[i].end_time != "") {
//							var index_t = 'time' + i;
//							str += '<div class="' + index_t + ' time">';
//							var index_d = 't_d' + i;
//							var index_h = 't_h' + i;
//							var index_m = 't_m' + i;
//							str += '<span class="' + index_d + '">00天</span>';
//							str += '<span class="' + index_h + '">00时</span>';
//							str += '<span class="' + index_m + '">00分</span>';
//							str += '</div>';
//
//						} else {
//							str += '</li>';
//						}
//
//						//          	console.log(str);
//						$('.proItem').append(str);
//						var time = msg[i].end_time * 1000;
//						//					var time = getLocalTime(msg[i].end_time).replace(/-/g,"/");
//						//	时间倒计时
//						//					          	console.log(time)
//
//						var EndTime = new Date(time);
//						var NowTime = new Date();
//						var t = time - NowTime.getTime();
//						console.log(t)
//						if(t < 0) {
//							$("." + index_t).html("活动已结束")
//						}
//						var d = Math.floor(t / 1000 / 60 / 60 / 24);
//						var h = Math.floor(t / 1000 / 60 / 60 % 24);
//						var m = Math.floor(t / 1000 / 60 % 60);
//						var s = Math.floor(t / 1000 % 60);
//						$("." + index_d).html(d + "天");
//						$("." + index_h).html(h + "时");
//						$("." + index_m).html(m + "分");
//						//     			$("."+index_s).html(s + "秒");
//
//						// 				console.log(timer);
//
//					})(i)
//				}
//			} else {
//							str = "<img class='nomore' src='../../../images/base/nomore.png' style='width: 100%;'/>";
//							$('.proItem').html(str);
//							//将排序禁止点击
//							//				$(".orderItem li").css("pointer-events", "none");
//						};
//
//					}
//				})

			});

		},
		error: function(data) {
			console.log('bbbbb');
		}
	});

	$(".checkModel").hide();
	$(".overLay").hide();
});

//点击遮罩层
$(".overLay").click(function() {
	$(".checkModel").hide();
	$(".overLay").hide();
});
//删除数组指定值
function removeByValue(arr, val) {
	for(var i = 0; i < arr.length; i++) {
		if(arr[i] == val) {
			arr.splice(i, 1);
			break;
		}
	}
}
//输入字符限制
$(".proName").each(function() {
	var text = $(this).text();
	//console.log( text.length)
	if(text.length > 12) {
		str = text.substr(0, 12) + '...';
		$(this).text(str)
	}
})
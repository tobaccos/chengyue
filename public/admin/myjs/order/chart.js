$(document).ready(function() {
	$("#chart").click(function() {

		var title = {
			text: '产品销量图'
		};
		var subtitle = {

		};
		var xAxis = {
			categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']
		};
		var yAxis = {
			title: {
				text: '产品销量'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		};
		var tooltip = {
			valueSuffix: '个'
		}
		var legend = {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 0
		};
		series = [{
			name: '销量',
			data: []
		}, ];
		var id = $('#id').val();
		var time = $('#time').val();
		var class1 = $('#class1').val();
//		    console.log(time);
//		    console.log(id);
		$.ajax({

			type: "GET",
			url:chaUrl ,
			data: {
				"id": id,
				"time": time,
				"class":class1
			},
			success: function(msg) {
				series[0].data = msg;
				var json = {};
				json.title = title;
				json.subtitle = subtitle;
				json.xAxis = xAxis;
				json.yAxis = yAxis;
				json.tooltip = tooltip;
				json.legend = legend;
				json.series = series;
				json.exporting= {
        enabled: false
    	}
				$('#container').highcharts(json);
			},
			error: function(data) {

			}
		});

	})
});

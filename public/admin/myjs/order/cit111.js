function swapCheck() {
		 if (isCheckAll) {
			 $("input[type='checkbox']").each(function() {
				 this.checked = false;
			 });
			 isCheckAll = false;
		 } else {
			 $("input[type='checkbox']").each(function() {
				 this.checked = true;
			 });
			 isCheckAll = true;
		 }
	 }

	 $(document).ready(function() {
	   $(".cha").click(function() {
	     var id = $(this).attr('rel');
	     $("#Modal .modal-body > form").attr("action", "ciriticalReject/" + id);
	   });
	 });


	 $(".cal").click(function() {
			var ids = $(this).attr('rel');
		$.ajax({
					 type: "Get",
					 url:calUrl +ids,
					 success: function(msg){
						//  layer.msg(msg, {
						// 	 time: 3000
						//  });
						layer.msg(msg, {time:3000,icon: 0});
					  setTimeout("location.reload();",1000);

					},
					 error:function(){

					 }
			 });
	 })

	 $(".btn-success").click(function() {
			var ids = $(this).attr('rel');
		$.ajax({
					 type: "Get",
					 url:sucUrl+ids,
					 success: function(msg){
						 layer.msg(msg, {time:3000,icon: 0});
						//  layer.msg(msg, {
						// 	 time: 3000
						//  });
					  setTimeout("location.reload();",1000);

					},
					 error:function(){

					 }
			 });
	 })

	 $(".btn-danger").click(function() {
			var ids = $(this).attr('rel');
		$.ajax({
					 type: "Get",
					 url:danUrl +ids,
					 success: function(msg){
						 layer.msg(msg, {time:3000,icon: 0});
					   setTimeout("location.reload();",1000);

					},
					 error:function(){

					 }
			 });
	 })

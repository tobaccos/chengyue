$(".back").click(function(){
//	 window.history.go(-1)
    var urlBack = document.referrer;
    window.location.href = urlBack;
});
   $(".back1").click(function(){
       window.history.go(-2)
   })
   $(".goback").click(function(){
   	   window.history.go(-1)
   })


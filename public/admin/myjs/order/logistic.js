function libid(id) {
  // $('.del').click(function(){
  var name=$('#name').val();
  var code=$('#code').val();
  //      console.log(name);
  //      console.log(code);
  //      return false;
  layer.confirm('确定要出库吗？', {
    btn: ['确定','取消']
  }, function(){
    $.ajax({
      type: "GET",
      url:libUrl,
      data:{"id":id ,"name":name,"code":code} ,
      success: function(msg){
        layer.msg(msg, {time:3000,icon: 0});
      },
      error:function(data){

      }
    });
  }, function(){

  });
}

$("#btnPrint").click(function(){
    $("#printArea").jqprint();
});

 $("#btnPrintFull").click(function(){
    $("body").printArea();
 });


 $(function(){
   // Set up the number formatting.
   $('.num').number( true, 2 );
 });

 function today(){
      var today=new Date();
      var h=today.getFullYear();
      var m=today.getMonth()+1;
      var d=today.getDate();
      var o=today.getHours();
      var i=today.getMinutes();
      if (m >= 1 && m<= 9) {
          m = "0" + m;
      }
      if (d >= 0 && d <= 9) {
          d = "0" + d;
      }
      if (o >= 1 && o<= 9) {
          o = "0" + o;
      }
      if (i >= 0 && i <= 9) {
          i = "0" + i;
      }
      return h+""+m+""+d+""+o+""+i;
    }
  timccc.onclick=function(){
    document.getElementById("code").value = today();
    document.getElementById("name").value="自营物流";
    }

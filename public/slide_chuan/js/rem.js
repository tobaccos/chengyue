(function(){

    var num = 1/window.devicePixelRatio;

    document.write('<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale='+num+', maximum-scale='+num+', minimum-scale='+num+'" />');

    var fontSize = document.documentElement.clientWidth/10;

    document.querySelector('html').style.fontSize = fontSize+'px';


    $(window).scroll(function(){
        if ($(window).scrollTop()>10){
            $(".circle").fadeIn(1000);
        }
        else
        {
            $(".circle").fadeOut(1000);
        }
    });

    //当点击跳转链接后，回到页面顶部位置

    $(".circle").click(function(){
        $('body,html').animate({scrollTop:0},1000);
        console.log("dasfaa");
        return false;
    });



})();

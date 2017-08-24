//顶部导航显示隐藏
(function(){
    $('.menu').click(function(){
        $('.menu_show').toggle(500);
        $('.xiala').css('display','block')
    });
    $('.xiala').click(function(){
        $('.menu_show').hide(500)

    });
})();


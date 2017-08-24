/**
 * Created by Administrator on 2017/6/1.
 */
var flag=1;
//颜色标志选择
$('#bgFlagCh').click(function () {
    if(flag==1){
        $('.bgColorCh').css('display','inline-block');
        flag=0;
    }
    else{
        $('.bgColorCh').css('display','none');
        flag=1;
    }
})
$('.bgColorCh').click(function () {
    var color=$(this).css('background-color');
    $('#bgFlagCh').css('background',color);
    $('#colorCh').val(color);
})
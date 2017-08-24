$(function() {
    $('#myShare').click(function() {
        var shareUrl =location.href;   //当前地址栏的链接地址

        if (condition="CONTROLLER_NAME == 'Member' ") {
            var str = "http://<?php echo $_SERVER['HTTP_HOST'];?>";
        }
        else
        {
            var str = "http://<?php echo $_SERVER['HTTP_HOST'];?>__SELF__";
        }

        if(str.indexOf("par") < 0) {
            if(condition="CONTROLLER_NAME == 'Member' ") {
                var str = "http://<?php echo $_SERVER['HTTP_HOST'];?>/Home/Index/index/par/<{$userInfo.id}>";
            }
            else {
                var str = "http://<?php echo $_SERVER['HTTP_HOST'];?>__SELF__/par/<{$userInfo.id}>";
            }
        }
        str = str.replace(/\.html/g, '', str);

    });
    $(document).keyup(function(event) {
        if(event.keyCode == 13) {//13代表回车
            return false;
        }
    });
});
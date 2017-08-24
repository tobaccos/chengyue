/**
 * Created by Administrator on 2017/5/25.
 */
/**
 * Created by Administrator on 2017/5/19.
 */

//checkbox 全选/取消全选
var isCheckAll = false;
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
// 批量选择
$('#mydel').click(function () {
    layer.confirm('您确定要删除这个属性吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        var checkedList = new Array();
        $("input[del='delcheck']:checked").each(function() {
            checkedList.push($(this).attr('value'));
        });
        $.ajax({
            type: "POST",
            url: delUrl,
            data: {'delitems':checkedList},
            success: function(result) {
                // console.log(result);
                if(result.state == 1){
                    layer.msg(result.msg);
                    window.location.reload();
                }
            }
        })
    });
})
/**
 * Created by Administrator on 2017/5/19.
 */
//复制产品
function copyCate(copy_id) {
    layer.confirm('您确定要复制这个产品吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: copyPro + copy_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data.status==1){
                    location.href = location.href;
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            }
        });
    });
}
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
    layer.confirm('您确定要删除这个产品吗？', {
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
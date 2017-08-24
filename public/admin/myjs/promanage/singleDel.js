/**
 * Created by Administrator on 2017/6/3.
 */
//删除单个产品
function delCate(cate_id) {
    layer.confirm('您确定要删除这个产品吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: singleDel + cate_id,
            data:{
                '_method':'delete'
            },
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
/**
 * Created by Administrator on 2017/5/19.
 */
//  图标
$('#attrType').selectpicker({
    'selectedText': 'cat'
});
//选中的value，存在这个数组
var valArr =[];
$(".dropdown-menu li").click(function () {
    //当前选中项的value
    var thisVal = $(this).attr("data-original-index");
    if(!$(this).hasClass("selected")) {
        valArr.push(thisVal);
        console.log("测试", valArr);
    }else {
        removeByValue(valArr,thisVal) ;
        console.log("测试2", valArr);
    }
});
//点击提交，将它添加到下拉框
$(".submitAttr").click(function () {
    //获取属性弹框的属性名称
    var proAttrVal = $("#proattr").val();
    //获取属性的value
    var attrValue = $("#proattr").attr("attrVal");
    //获取属性类型
    var attrType = $(".attrRadio:checked").siblings("span").text();
    console.log(attrType);
    $('#attrType').append("<option value="+attrValue+">"+proAttrVal+"("+attrType+")"+"</option>");
    $('#attrType').selectpicker('refresh');
    $(".close").click();
});
// 下拉框多选复现

//选中属性的value
//Mustard放置多选属性value的数组
$('#attrType').selectpicker('val', 'Mustard');


//删除option选项
function removeOne(){
    var obj=$('#attrType');
    var index=obj.selectedIndex; //index,要删除选项的序号
    obj.options.remove(index);
}

//删除数组指定值
function removeByValue(arr, val) {
    for(var i=0; i<arr.length; i++) {
        if(arr[i] == val) {
            arr.splice(i, 1);
            break;
        }
    }
}

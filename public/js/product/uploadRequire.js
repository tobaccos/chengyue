var file1 = '';
var file2 = '';
var file1Name = '';
var file1Type = '';
var file1Path = '';
var file2Name = '';
var file2Type = '';
var file2Path = '';
function previewFile1() {
    var preview = document.querySelector('.image_1');
    file1    = document.querySelector('.upImg1 input[type=file]').files[0];
    var reader  = new FileReader();
    file1Type = file1.type;
    file1Name = file1.name;
    file1Path    = document.querySelector('.upImg1 input[type=file]').value;//图片路径

    if(file1Type == "image/jpeg" || file1Type == "image/jpg" || file1Type == "image/png" || file1Type == "image/bmp") {
        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file1) {
            reader.readAsDataURL(file1);
        }
    }else {
        alert("请上传jpg/jpeg/png/bmp格式的图片");
    }
    console.log("file1",file1Path);

}

function previewFile2() {
    var preview = document.querySelector('.image_2');
    file2    = document.querySelector('.upImg2 input[type=file]').files[0];
    var reader  = new FileReader();
    file2Type = file2.type;
    file2Name = file2.name;
    file2Path    = document.querySelector('.upImg2 input[type=file]').value;//图片路径

    if(file2Type == "image/jpeg" || file2Type == "image/jpg" || file2Type == "image/png" || file2Type == "image/bmp") {
        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file2) {
            reader.readAsDataURL(file2);
        }
    }else {
        alert("请上传jpg/jpeg/png/bmp格式的图片");
    }
    console.log("file2",file2);
}

$(".iDo").click(function() {
    var formData = new FormData($("#uploadForm")[0]);

    $.ajax({
        type: "POST",
        url: upRequireUrl,
        data:formData,
        contentType:false,
        processData:false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(msg) {

            if(msg == "200") {
                var str1 = "<p class='layFont'>上传成功</p>";
                layer.msg(str1, {
                    time: 1000
                },function () {
                    window.history.go(-1);
                });

            }

            if(msg == "404") {
                var str2 = "<p class='layFont'>上传失败</p>";
                layer.msg(str2, {
                    time: 1000
                });
            }
            if(msg == "405") {
                var str3 = "<p class='layFont'>图片格式错误或未更改</p>";
                layer.msg(str3, {
                    time: 1000
                });
            }
            if(msg == "406") {
                var str3 = "<p class='layFont'>请填写需求</p>";
                layer.msg(str3, {
                    time: 1000
                });
            }
            if(msg == "403") {
                var str3 = "<p class='layFont'>图片没有对应的需求</p>";
                layer.msg(str3, {
                    time: 1000
                });
            }

        },
        error: function(data) {
            console.log('bbbbb');
        }
    });
});
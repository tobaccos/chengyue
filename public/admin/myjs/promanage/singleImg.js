/**
 * Created by Administrator on 2017/5/27.
 */
//单个照片上传
$(function() {
    var date=new Date().getTime();
    $('#file_upload1').uploadify({
        'buttonText' : '图片上传',
        'fileSizeLimit'   : '2048KB',
        'formData'     : {
            'timestamp' : date,
            '_token'     : token
        },
        'swf'      : swf,
        'uploader' : uploader,
        'onUploadSuccess' : function(file, data, response) {
            var obj=eval('('+data+')');
            $('#art_thumb_img').attr('src',obj.url);
            $('input[name=pic]').val(obj.name);
        }
    });
});
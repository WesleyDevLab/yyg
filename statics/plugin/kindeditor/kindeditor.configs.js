KindEditor.ready(function (K) {
    var seting = {
        themeType: "simple",
        width: "930",
        height:"200",
        resizeType: 1,
        syncType: "",
        allowPreviewEmoticons: false,
        items: [
            'source', 'undo', 'redo', 'plainpaste',  'wordpaste', 'clearhtml', 'quickformat', 'selectall', 'fullscreen', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'hr','removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
            'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'unlink', 'baidumap'],
        allowFileManager: true,
        afterCreate: function () {
            this.sync();
        },
        afterBlur: function () {
            this.sync();
        },
        allowFileManager: true,
        allowFlashUpload: false,
        allowMediaUpload: false,
        allowFileUpload: false,
        uploadJson : '/admin/ajax/upload_json?folder=u1_g1&is_thumg=1&thumg_width=160&thumg_height=120',
        fileManagerJson : '/admin/ajax/file_manager_json?folder=u1_g1'
    }
    editor = K.create('.kindEditors', seting);
    K('.choose_pic').click(function() {
    	var o = $(this);
        var data_id = o.parent().parent().parent().attr('data-id');
        editor.loadPlugin('image', function() {
            editor.plugin.imageDialog({
                imageUrl : o.parent().find('.tx_url').val(),
                clickFn : function(url, title, width, height, border, align) {
                	console.log(url);
                    var obj = o.parent().find('.thumb_img');
                    obj.show();
                    obj.attr('src',url);
                    $(".left-items").each(function(){
                        var t = $(this);
                        if(t.attr('data-id') == data_id){
                            t.find('.msg-thumb-wrp').css({"background-image":"url("+url+")"});
                        }
                    });
                    var obj2 = o.parent().find('.tx_url');
                    if(obj2.length>0){
                        obj2.attr('value',url);
                        obj2.hide();
                    }
                    editor.hideDialog();
                }
            });
        });
    });
});



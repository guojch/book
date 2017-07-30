/**
 * Created by Administrator on 2017/7/30.
 */

var upload = {
    error:function(msg){
        common_ops.alert(msg);
    },
    success:function(image_key){
        if(!image_key){
            return;
        }
        var html = '<img src="'+common_ops.buildPicUrl('brand',image_key)+'"><span class="fa fa-times-circle del del_image" data="'+image_key+'"><i></i></span>';
        if($(".upload_pic_wrap .pic-each").size() > 0){
            $(".upload_pic_wrap .pic-each").html(html);
        }else{
            $(".upload_pic_wrap").append('<span class="pic-each">' + html + '</span>');
        }

        // <input type="file"/> 如果上传同一个文件，change事件触发一次后就不会触发了，所以先删除再添加，重新绑定。
        var html_file = '<input type="file" name="pic" accept="image/png, image/jpeg, image/jpg,image/gif">';
        $("#brand_image_wrap .upload_pic_wrap input[name=pic]").remove();
        $(".upload_pic_wrap .upload_wrap").append(html_file);

        // 添加绑定的删除动作
        brand_image_ops.delete_img();
        brand_image_ops.change_img();
    }
};
var brand_image_ops = {
    init:function(){
        this.eventBind();
        this.delete_img();
        this.change_img();
    },
    eventBind:function(){
        $(".set_pic").click(function(){
            $('#brand_image_wrap').modal('show');
        });

        $("#brand_image_wrap .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交。");
                return false;
            }

            if( $("#brand_image_wrap .pic-each").size() < 1 ){
                common_ops.alert( "请上传图片。"  );
                return false;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url:common_ops.buildWebUrl("/brand/edit-image") ,
                type:'POST',
                data:{
                    image_key:$("#brand_image_wrap .pic-each .del_image").attr("data")
                },
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = window.location.href;
                        }
                    }
                    common_ops.alert(res.msg,callback);
                }
            });
        });

        $(".remove").click( function(){
            var id = $(this).attr("data");
            var callback = {
                'ok':function(){
                    $.ajax({
                        url:common_ops.buildWebUrl("/brand/image-ops"),
                        type:'POST',
                        data:{
                            id:id
                        },
                        dataType:'json',
                        success:function(res){
                            var callback = null;
                            if(res.code == 200){
                                callback = function(){
                                    window.location.href = window.location.href;
                                }
                            }
                            common_ops.alert( res.msg,callback );
                        }
                    });
                },
                'cancel':null
            };
            common_ops.confirm( "确定删除？",callback );
        });
    },
    delete_img:function(){
        $("#brand_image_wrap .del_image").unbind().click(function(){
            $(this).parent().remove();
        });
    },
    change_img: function(){
        $("#brand_image_wrap .upload_pic_wrap input[name=pic]").change(function(){
            $("#brand_image_wrap .upload_pic_wrap").submit();
        });
    }
};

$(function(){
    brand_image_ops.init();
});
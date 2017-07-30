/**
 * Created by Administrator on 2017/7/18.
 */
var upload = {
    success: function(image_key){
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
        $(".wrap_brand_set .upload_pic_wrap input[name=pic]").remove();
        $(".upload_pic_wrap .upload_wrap").append(html_file);

        // 添加绑定的删除动作
        brand_edit_ops.delete_img();
        brand_edit_ops.change_img();
    },
    error: function(msg){
        common_ops.alert(msg);
    }
}

var brand_edit_ops = {
    init:function(){
        this.eventBind();
        this.delete_img();
        this.change_img();
    },
    eventBind:function(){
        $(".wrap_brand_set .save").click(function(){
            var btn_target = $(this);
            if(btn_target.hasClass("disabled")){
                common_ops.alert('正在处理，请稍后再试。');
                return;
            }

            var name_target = $(".wrap_brand_set input[name=name]");
            var name = name_target.val();
            var image_key = $(".wrap_brand_set .pic-each .del_image").attr("data");
            var phone_target = $(".wrap_brand_set input[name=phone]");
            var phone = phone_target.val();
            var address_target = $(".wrap_brand_set input[name=address]");
            var address = address_target.val();
            var description_target = $(".wrap_brand_set textarea[name=description]");
            var description = description_target.val();

            if(name.length < 1){
                common_ops.tip('请输入品牌名称。',name_target);
                return;
            }
            if($(".upload_pic_wrap .pic-each").size() < 1){
                common_ops.alert('请上传品牌logo。');
                return;
            }
            if(phone.length < 1){
                common_ops.tip('请输入手机号码。',phone_target);
                return;
            }
            if(address.length < 1){
                common_ops.tip('请输入地址。',address_target);
                return;
            }
            if(description.length < 1){
                common_ops.tip('请输入品牌介绍。',description_target);
                return;
            }

            btn_target.addClass("disabled");

            var data = {
                name:name,
                image_key:image_key,
                phone:phone,
                address:address,
                description:description
            }

            $.ajax({
                url:common_ops.buildWebUrl('/brand/edit'),
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if(res.code == 200){
                        callback = function(){
                            location.href = common_ops.buildWebUrl('/brand/info');
                        };
                    }
                    common_ops.alert(res.msg,callback);
                }
            });

        });
    },
    delete_img: function(){
        $(".wrap_brand_set .del_image").unbind().click(function(){
            $(this).parent().remove();
        });
    },
    change_img: function(){
        $(".wrap_brand_set .upload_pic_wrap input[name=pic]").change(function(){
            $(".wrap_brand_set .upload_pic_wrap").submit();
        });
    }
}

$(function(){
    brand_edit_ops.init();
});
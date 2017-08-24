;
var upload = {
    error:function(msg){
        $.alert(msg);
    },
    success:function(file_key,type){
        if(!file_key){
            return;
        }
        var html = '<img src="'+common_ops.buildPicUrl("brand",file_key)+'"/>'
            +'<span class="fa fa-times-circle del del_image" data="'+file_key+'"></span>';

        if( $(".upload_pic_wrap .pic-each").size() > 0 ){
            $(".upload_pic_wrap .pic-each").html( html );
        }else{
            $(".upload_pic_wrap").append('<span class="pic-each">'+ html + '</span>');
        }
        brand_set_ops.delete_img();
    }
};
var brand_set_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".wrap_brand_set .upload_pic_wrap input[name=pic]").change(function(){
            $(".wrap_brand_set .upload_pic_wrap").submit();
        });

        $(".wrap_brand_set .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }

            var name_target = $(".wrap_brand_set input[name=name]");
            var name = name_target.val();
            var mobile_target = $(".wrap_brand_set input[name=mobile]");
            var mobile = mobile_target.val();
            var address_target = $(".wrap_brand_set input[name=address]");
            var address = address_target.val();
            var description_target = $(".wrap_brand_set textarea[name=description]");
            var description = description_target.val();
            if( name.length < 1 ){
                common_ops.tip( "请输入符合规范的品牌名称~~" ,name_target );
                return;
            }

            if( $(".wrap_brand_set .pic-each").size() < 1 ){
                common_ops.alert( "请上传品牌Logo~~"  );
                return;
            }

            if( mobile.length < 1 ){
                common_ops.tip("请输入符合规范的手机号码~~",mobile_target);
                return;
            }

            if( address.length < 1  ){
                common_ops.tip("请输入符合规范的地址~~",address_target);
                return;
            }

            if( description.length < 1  ){
                common_ops.tip("请输入符合规范的品牌介绍~~",description_target);
                return;
            }

            btn_target.addClass("disabled");

            var data = {
                name:name,
                logo:$(".wrap_brand_set .pic-each .del_image").attr("data"),
                mobile:mobile,
                address:address,
                description:description
            };

            $.ajax({
                url:common_ops.buildWebUrl("/brand/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildWebUrl("/brand/info");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });
        });
    },
    delete_img:function(){
        $(".wrap_brand_set .del_image").unbind().click(function(){
            $(this).parent().remove();
        });
    }
};

$(document).ready( function(){
    brand_set_ops.init();
});
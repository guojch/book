/**
 * Created by Administrator on 2017/7/18.
 */
var brand_edit_ops = {
    init:function(){
        this.eventBind();
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
    }

}

$(function(){
    brand_edit_ops.init();
});
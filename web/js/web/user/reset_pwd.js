/**
 * Created by Administrator on 2017/7/9.
 */
var user_reset_pwd_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $('.save').click(function(){
            var btn_target = $(this);
            if(btn_target.hasClass('disabled')){
                alert('正在处理，请不要重复点击。');
                return false;
            }

            var old_password = $('#old_password').val();
            var new_password = $('#new_password').val();
            if(old_password.length < 1){
                common_ops.tip('请输入原密码。',$('#old_password'));
                return false;
            }
            if(new_password.length < 6){
                common_ops.tip('请输入不少于6位字符的新密码。',$('#new_password'));
                return false;
            }

            btn_target.addClass('disabled');

            $.ajax({
                url:common_ops.buildWebUrl('/user/reset-pwd'),
                type:'POST',
                dataType:'json',
                data:{
                    old_password:old_password,
                    new_password:new_password
                },
                success:function(res){
                    btn_target.removeClass('disabled');
                    var callback = null;
                    if(res.code == 200){
                        callback = function(){
                            location.reload();
                        };
                    }
                    common_ops.alert(res.msg,callback);
                }
            });
        })
    }
};

$(function(){
    user_reset_pwd_ops.init();
});
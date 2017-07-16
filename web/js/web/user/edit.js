/**
 * Created by Administrator on 2017/7/9.
 */
var user_edit_ops = {
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

            var username = $(".user_edit_wrap input[name='username']").val();
            var email = $(".user_edit_wrap input[name='email']").val();
            if(username.length < 1){
                common_ops.tip('请输入合法的姓名。',$(".user_edit_wrap input[name='username']"));
                return false;
            }
            if(email.length < 1){
                common_ops.tip('请输入合法的邮箱地址。',$(".user_edit_wrap input[name='email']"));
                return false;
            }

            btn_target.addClass('disabled');

            $.ajax({
                url:common_ops.buildWebUrl('/user/edit'),
                type:'POST',
                dataType:'json',
                data:{
                    username:username,
                    email:email
                },
                success:function(res){
                    btn_target.removeClass('disabled');
                    callback = null;
                    if(res.code == 200){
                        callback = function(){
                            location.reload();
                        };
                    }
                    common_ops.alert(res.msg,callback);
                }
            });
        });
    }
};

$(function(){
    user_edit_ops.init();
});
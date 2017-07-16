/**
 * Created by Administrator on 2017/7/15.
 */
var account_edit_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".wrap_account_set .save").click(function(){
            var btn_target = $(this);
            if(btn_target.hasClass("disabled")){
                common_ops.alert('正在处理，请稍后再试。');
                return;
            }

            var username_target = $(".wrap_account_set input[name=username]");
            var phone_target = $(".wrap_account_set input[name=phone]");
            var email_target = $(".wrap_account_set input[name=email]");
            var login_name_target = $(".wrap_account_set input[name=login_name]");
            var login_pwd_target = $(".wrap_account_set input[name=login_pwd]");
            var user_id_target = $(".wrap_account_set input[name=user_id]");

            var username = username_target.val();
            var phone = phone_target.val();
            var email = email_target.val();
            var login_name = login_name_target.val();
            var login_pwd = login_pwd_target.val();
            var user_id = user_id_target.val();

            if(username.length < 1){
                common_ops.tip('请输入符合规范的姓名。',username_target);
                return;
            }
            if(phone.length < 1){
                common_ops.tip('请输入符合规范的手机。',phone_target);
                return;
            }
            if(email.length < 1){
                common_ops.tip('请输入符合规范的邮箱。',email_target);
                return;
            }
            if(login_name.length < 1){
                common_ops.tip('请输入符合规范的登录名。',login_name_target);
                return;
            }
            if(login_pwd.length < 1){
                common_ops.tip('请输入符合规范的密码。',login_pwd_target);
                return;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url:common_ops.buildWebUrl("/account/edit"),
                type:'POST',
                data:{
                    username:username,
                    phone:phone,
                    email:email,
                    login_name:login_name,
                    login_pwd:login_pwd,
                    user_id:user_id
                },
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if(res.code == 200){
                        callback = function(){
                            window.location.href = common_ops.buildWebUrl("/account/list");
                        }
                    }
                    common_ops.alert(res.msg,callback);
                }
            });
        });
    }
};

$(function(){
    account_edit_ops.init();
});
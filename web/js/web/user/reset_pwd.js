;
var mod_pwd_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $("#save").click(function(){
            var btn_target  = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理，请不要频繁点击~~");
                return;
            }

            var old_password = $("#old_password").val();
            if(!old_password){
                common_ops.tip("请输入原密码~~",$("#old_password"));
                return false;
            }

            var new_password = $("#new_password").val();
            if(!new_password || new_password.length<6){
                common_ops.tip("请输入不少于6位的新密码！",$("#new_password") );
                return false;
            }

            btn_target.addClass("disabled");

            var data = {
                'old_password':$("#old_password").val(),
                'new_password':$("#new_password").val()
            };
            $.ajax({
                url:common_ops.buildWebUrl('/user/reset-pwd'),
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = window.location.href;
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });
        });

    }
};
$(document).ready(function(){
    mod_pwd_ops.init();
});
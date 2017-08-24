;

var qrcode_set_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){

        $(".wrap_qrcode_set .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }

            var name_target = $(".wrap_qrcode_set input[name=name]");
            var name = name_target.val();

            if( name.length < 1 ){
                common_ops.tip( "请输入符合规范的营销渠道名称~~" ,name_target );
                return;
            }
            btn_target.addClass("disabled");

            var data = {
                name:name,
                id:$(".wrap_qrcode_set input[name=id]").val()
            };

            $.ajax({
                url:common_ops.buildWebUrl("/qrcode/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildWebUrl("/qrcode/index");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });
        });
    }
};

$(document).ready( function(){
    qrcode_set_ops.init();
});
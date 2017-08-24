;
var user_order_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".order_header").click(function () {
            $(this).next().toggle();
        });

        $(".close").click( function() {

            if( !confirm("确认取消订单？") ){
                return;
            }

            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert("正在处理!!请不要重复提交");
                return;
            }
            $.ajax({
                url:common_ops.buildMUrl("/order/ops"),
                type:'POST',
                data:{
                    act:'close',
                    id:btn_target.attr("data")
                },
                dataType:'json',
                success:function( res ){
                    btn_target.removeClass("disabled");
                    alert( res.msg );
                    if( res.code == 200 ){
                        window.location.href = window.location.href;
                    }
                }
            });
        });

        $(".confirm_express").click( function() {
            if( !confirm("确认收货？") ){
                return;
            }
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert("正在处理!!请不要重复提交");
                return;
            }
            $.ajax({
                url:common_ops.buildMUrl("/order/ops"),
                type:'POST',
                data:{
                    act:'confirm_express',
                    id:btn_target.attr("data")
                },
                dataType:'json',
                success:function( res ){
                    btn_target.removeClass("disabled");
                    alert( res.msg );
                    if( res.code == 200 ){
                        window.location.href = window.location.href;
                    }
                }
            });
        });
    }
};

$(document).ready( function(){
    user_order_ops.init();
});

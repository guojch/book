;
var user_comment_set_ops = {
    init:function(){
        this.score = 0;
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $('#star').raty({
            half: true,
            click:function( score, evt ){
                that.score = score;
            }
        });

        $(".op_box .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert("正在处理!!请不要重复提交");
                return;
            }

            var score = that.score;
            var content = $(".addr_form_box textarea[name=content]").val();

            if( score <= 0 ){
                alert("请打分~~");
                return;
            }

            if( content.length < 3  ){
                alert("请输入符合要求的评论内容~~");
                return;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url :common_ops.buildMUrl("/user/comment_set"),
                type:'POST',
                data: {
                    pay_order_id:$(".op_box input[name=pay_order_id]").val(),
                    book_id:$(".op_box input[name=book_id]").val(),
                    score:score,
                    content:content
                },
                dataType:'json',
                async: false,
                success:function(res){
                    btn_target.removeClass("disabled");
                    alert(res.msg);
                    if( res.code == 200 ){
                        window.location.href = common_ops.buildMUrl("/user/comment") ;
                    }

                }
            })

        });
    }
};

$(document).ready( function(){
    user_comment_set_ops.init();
});
/**
 * Created by Administrator on 2017/7/9.
 */
var account_list_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var _this = this;
        $(".search").click(function(){
            $(".wrap_search").submit();
        });

        $(".remove").click(function(){
            if(confirm("确定删除？")){
                _this.ops("remove",$(this).attr("data"));
            }
        });

        $(".recover").click(function(){
            if(confirm("确定恢复？")){
                _this.ops("recover",$(this).attr("data"));
            }
        });
    },
    ops:function(act,id){
        callback = {
            'ok':function(){
                $.ajax({
                    url:common_ops.buildWebUrl("/account/ops"),
                    type:'POST',
                    dataType:'json',
                    data:{
                        act:act,
                        id:id
                    },
                    success:function(res){
                        callback = null;
                        if(res.code == 200){
                            callback = function(){
                                location.reload();
                            };
                        }
                        common_ops.alert(res.msg,callback);
                    }
                });
            },
            'cancel':function(){
            }
        }
        common_ops.confirm((act == 'remove')?'确定删除？':'确定恢复？',callback);
    }
};

$(function(){
    account_list_ops.init();
});
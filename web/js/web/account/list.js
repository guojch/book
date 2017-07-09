/**
 * Created by Administrator on 2017/7/9.
 */
var account_list_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $('.search').click(function(){
            $('.wrap_search').submit();
        });
    }
};

$(function(){
    account_list_ops.init();
});
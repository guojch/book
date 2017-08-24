;
var user_fav_list = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".fav_list li .del_fav").click(function () {
            $(this).parent().remove();
            $.ajax({
                url:common_ops.buildMUrl("/product/fav"),
                type:'POST',
                data:{
                    id:$(this).attr("data"),
                    act:'del'
                },
                dataType:'json',
                success:function( res ){
                }
            });
        });
    }
};
$(document).ready( function(){
    user_fav_list.init();
} );

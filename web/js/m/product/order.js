;
var product_order_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".do_order").click( function () {

            var address_id = $(".address_list input[name=address_id]:checked").val();
            if( address_id == undefined ){
                alert("请选择收货地址~~");
                return;
            }


            var data = [];
            $(".order_list li").each( function(){
                var tmp_book_id = $(this).attr("data");
                var tmp_quantity = $(this).attr("data-quantity");
                data.push( tmp_book_id + "#" + tmp_quantity );
            });

            if( data.length < 1 ){
                alert("请选择了商品在提交~~");
                return;
            }

            $.ajax({
                url:common_ops.buildMUrl("/product/order"),
                type:'POST',
                data:{
                    product_items:data,
                    address_id:address_id,
                    sc:$(".op_box input[name=sc]").val()
                },
                dataType:'json',
                success:function( res ){
                    alert( res.msg );
                    if( res.code == 200 ){
                        window.location.href = res.data.url;
                    }
                }
            });
        });
    }
};

$(document).ready( function(){
    product_order_ops.init();
});

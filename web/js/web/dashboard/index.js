;
var dashboard_index_ops = {
    init:function(){
        this.drawChart();
    },
    drawChart:function(){
        charts_ops.setOption();
        $.ajax({
            url:common_ops.buildWebUrl("/charts/dashboard"),
            dataType:'json',
            success:function( res ){
                charts_ops.drawLine( $('#member_order'),res.data )
            }
        });

        $.ajax({
            url:common_ops.buildWebUrl("/charts/finance"),
            dataType:'json',
            success:function( res ){
                charts_ops.drawLine( $('#finance'),res.data )
            }
        });
    }
};

$(document).ready( function(){
    dashboard_index_ops.init();
});
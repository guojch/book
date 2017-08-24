<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/m/user/order.js",\app\assets\MAsset::className() );
?>
<div class="page_title clearfix">
    <span>订单列表</span>
</div>
<?php if( $list ):?>
    <?php foreach( $list as $_item ):?>
<div class="order_box mg-t20">
	<div class="order_header">
		<h2>订单编号: <?=$_item['sn'];?></h2>
		<p>下单时间：<?=$_item['created_time'];?> 状态：<?=$_item['status_desc'];?></p>
		<?php if( $_item['status'] == 1 ):?>
		<p>快递状态：<?=$_item['express_status_desc'];?></p>
            <?php if( $_item['express_info'] ):?>
            <p>快递信息：<?=$_item['express_info'];?></p>
            <?php endif;?>
        <?php endif;?>
		<span class="up_icon"></span>
	</div>
	<ul class="order_list">
        <?php foreach( $_item['items'] as $_item_info ):?>
		<li>
			<a href="<?=UrlService::buildNullUrl( );?>">
				<i class="pic">
                    <img src="<?=$_item_info['book_main_image'];?>"  style="width: 100px;height: 100px;"/>
                </i>
				<h2><?=$_item_info['book_name'];?> </h2>
				<h3>&nbsp;</h3>
				<h4>&nbsp;</h4>
				<b>¥ <?=$_item_info['pay_price'];?></b>
			</a>
            <?php if( $_item['status'] == 1 && $_item['express_status'] == 1 && !$_item_info['comment_status'] ):?>
            <a style="display: block;position: absolute;bottom: 1rem;right: 1rem;" class="button"   href="<?=UrlService::buildMUrl("/user/comment_set",[ 'pay_order_id' => $_item['id'],'book_id' => $_item_info['book_id'] ]);?>">我要评论</a>
            <?php endif;?>
		</li>
		<?php endforeach;?>
	</ul>
	<?php if( $_item['status'] == -8 ):?>
        <div class="op_box border-top">
            <a style="display: inline-block;" class="button close" data="<?=$_item['id'];?>" href="<?=UrlService::buildNullUrl();?>">取消订单</a>
            <a style="display: inline-block;" class="button"  href="<?=$_item["pay_url"];?>">微信支付</a>
        </div>
	<?php elseif( $_item['status'] == 1 && $_item['express_status'] == -6):?>
            <div class="op_box border-top">
                <a style="display: inline-block;" data="<?=$_item['id'];?>"  href="<?=UrlService::buildNullUrl();?>"  class="button confirm_express">确认收货</a>
            </div>
	<?php endif;?>
</div>

<?php endforeach;?>
<?php else:?>
    <div class="no-data">
        悲剧啦，连个订单都咩有了~~
    </div>
<?php endif;?>

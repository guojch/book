<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/m/product/order.js",\app\assets\MAsset::className() );
?>
<div class="page_title clearfix">
    <span>订单提交</span>
</div>
<div class="order_box">
    <div class="order_header">
        <h2>确认收货地址</h2>
    </div>

    <ul class="address_list">
		<?php if( $address_list ):?>
            <?php foreach( $address_list as $_idx => $_address_info  ):?>
            <li style="padding: 5px 5px;">
                <label>
                    <input style="display: inline;" type="radio" name="address_id" value="<?=$_address_info['id'];?>" <?php if($_address_info['is_default'] || $_idx == 0 ):?> checked <?php endif;?>  >
                    <?=$_address_info['address'];?>（<?=$_address_info['nickname'];?>收）<?=$_address_info['mobile'];?>
                </label>

            </li>
            <?php endforeach;?>
		<?php else:?>
            <li style="padding: 5px 5px;"> <a href="<?=UrlService::buildMUrl('/user/address_set');?>">快去添加收货地址啦~~</a></li>
		<?php endif;?>
    </ul>


	<div class="order_header">
		<h2>确认订单信息</h2>
	</div>
	<?php if( $product_list ):?>
	<ul class="order_list">
		<?php foreach( $product_list as $_item ):?>
		<li data="<?=$_item["id"];?>" data-quantity="<?=$_item['quantity'];?>">
			<a href="<?=UrlService::buildMUrl("/product/info",[ "id" => $_item['id'] ]);?>">
				<i class="pic">
					<img src="<?=$_item["main_image"];?>" style="width: 100px;height: 100px;"/>
				</i>
				<h2><?=$_item['name'];?> x <?=$_item['quantity'];?></h2>
				<h4>&nbsp;</h4>
				<b>¥ <?=$_item['price'];?></b>
			</a>
		</li>
		<?php endforeach;?>
	</ul>
	<?php endif;?>
	<div class="order_header" style="border-top: 1px dashed #ccc;">
		<h2>总计：<?=$total_pay_money;?></h2>
	</div>
</div>
<div class="op_box">
    <input type="hidden" name="sc" value="<?=$sc;?>">
	<input style="width: 100%;" type="button" value="确定下单" class="red_btn do_order"  />
</div>

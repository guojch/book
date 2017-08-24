<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/m/product/cart.js",\app\assets\MAsset::className() );
?>
<div class="order_pro_box">
    <?php if( $list ):?>
	<ul class="order_pro_list">
        <?php foreach( $list as $_item ):?>
		<li data-price="<?=$_item["book_price"];?>">
			<a href="<?=UrlService::buildMUrl("/product/info",[ 'id' => $_item['book_id'] ]);?>" class="pic" >
                <img src="<?=$_item["book_main_image"];?>" style="height: 100px;width: 100px;"/>
            </a>
			<h2><a href="<?=UrlService::buildMUrl("/product/info",[ 'id' => $_item['book_id'] ]);?>"><?=$_item["book_name"];?></a></h2>
			<div class="order_c_op">
				<b>¥<?=$_item["book_price"];?></b>
				<span class="delC_icon" data="<?=$_item['id'];?>" data-book_id="<?=$_item['book_id'];?>"></span>
				<div class="quantity-form">
					<a class="icon_lower" data-book_id="<?=$_item['book_id'];?>" ></a>
					<input type="text" name="quantity" class="input_quantity" value="<?=$_item['quantity'];?>" readonly="readonly" max="<?=$_item['book_stock'];?>" />
					<a class="icon_plus" data-book_id="<?=$_item['book_id'];?>"></a>
				</div>
			</div>
		</li>
        <?php endforeach;?>
	</ul>
    <?php else:?>
    <div class="no-data">
        好可怜，购物车空空的
    </div>
    <?php endif;?>
</div>
<div class="cart_fixed">
	<a href="<?=UrlService::buildMUrl("/product/order",[ 'sc' => 'cart' ]);?>" class="billing_btn">结算</a>
	<b>合计：<strong>¥</strong><font id="price">0.00</font></b>
</div>
<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/m/pay/buy.js",\app\assets\MAsset::className() );
?>
<div class="order_box">
	<div class="order_header">
		<h2 style="text-align: center;">支付</h2>
	</div>
	<div class="fastway_list_box" style="padding-left: 20px;padding-bottom: 0px;">
		<ul class="fastway_list">
			<li><a href="<?=UrlService::buildNullUrl();?>" style="padding-left: 0.1rem;"><span>支付金额：<?=$pay_order_info['pay_price'];?></span></a></li>
			<li><a href="<?=UrlService::buildNullUrl();?>" style="padding-left: 0.1rem;"><span>支付备注：<?=$pay_order_info['note'];?></span></a></li>
		</ul>
	</div>
</div>
<div class="op_box">
	<input style="width: 100%;" type="button" value="微信支付" class="red_btn do_pay"  />
</div>

<div class="hide_wrap hidden">
	<input type="hidden" name="pay_order_id" value="<?=$pay_order_info['id'];?>">
</div>
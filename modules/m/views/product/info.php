<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/m/product/info.js",\app\assets\MAsset::className() );
?>
<div class="pro_tab clearfix">
    <span>图书详情</span>
</div>
<div class="proban">
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                <li><img src="<?=UrlService::buildPicUrl("book",$info['main_image'] );?>"/></li>
            </ul>
        </div>
    </div>
</div>
<div class="pro_header">
    <div class="pro_tips">
        <h2><?=UtilService::encode( $info['name'] );?></h2>
        <h3><b>¥<?=UtilService::encode( $info['price'] );?></b><font>库存量：<?=$info['stock'];?></font></h3>
    </div>
    <span class="share_span"><i class="share_icon"></i><b>分享商品</b></span>
</div>
<div class="pro_express">月销量：<?=$info['month_count'];?><b>累计评价：<?=$info['comment_count'];?></b></div>
<div class="pro_virtue">
    <div class="pro_vlist">
        <b>数量</b>
        <div class="quantity-form">
            <a class="icon_lower"></a>
            <input type="text" name="quantity" class="input_quantity" value="1" readonly="readonly" max="<?=$info["stock"];?>"/>
            <a class="icon_plus"></a>
        </div>
    </div>
</div>
<div class="pro_warp">
	<?=nl2br($info['summary']);?>
</div>
<div class="pro_fixed clearfix">
    <a href="<?= UrlService::buildMUrl("/"); ?>"><i class="sto_icon"></i><span>首页</span></a>
    <?php if( $has_faved ):?>
        <a class="fav has_faved" href="<?= UrlService::buildNullUrl( ); ?>"><i class="keep_icon"></i><span>已收藏</span></a>
    <?php else:?>
        <a class="fav" href="<?= UrlService::buildNullUrl( ); ?>" data="<?=$info['id'];?>"><i class="keep_icon"></i><span>收藏</span></a>
    <?php endif;?>
    <input type="button" value="立即订购" class="order_now_btn" data="<?=$info['id'];?>"/>
    <input type="button" value="加入购物车" class="add_cart_btn" data="<?=$info['id'];?>"/>
    <input type="hidden" name="id" value="<?=$info['id'];?>">
</div>

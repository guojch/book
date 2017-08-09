<?php
use yii\helpers\Html;
use app\common\services\UrlService;
use app\common\services\StaticService;
StaticService::includeAppJsStatic('/js/wap/brand/index.js',app\assets\WapAsset::className());
?>
<div style="min-height: 500px;">
	<div class="shop_header">
        <i class="shop_icon"></i>
        <strong><?= Html::encode($info['name']); ?></strong>
    </div>

    <?php if($image_list): ?>
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                <?php foreach($image_list as $_image_info): ?>
                <li><img style="max-height: 250px;" src="<?= UrlService::buildPicUrl('brand',$_image_info['image_key']); ?>" /></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="hd"><ul></ul></div>
    </div>
    <?php endif; ?>

    <div class="fastway_list_box">
        <ul class="fastway_list">
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>品牌名称：<?= Html::encode($info['name']); ?></span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>联系电话：<?= Html::encode($info['phone']); ?></span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>联系地址：<?= Html::encode($info['address']); ?></span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>品牌介绍：<?= Html::encode($info['description']); ?></span></a></li>
        </ul>
    </div>
</div>



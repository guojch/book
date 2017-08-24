<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/m/user/fav.js",\app\assets\MAsset::className() );
?>
<?php if( $list ):?>
<ul class="fav_list">
	<?php foreach( $list as $_item ):?>
	<li>
		<a href="<?=UrlService::buildMUrl("/product/info",[ 'id' => $_item['book_id'] ]);?>">
			<i class="pic"><img src="<?=$_item["book_main_image"];?>" style="height: 100px;width: 100px;" /></i>
			<h2><?=$_item["book_name"];?></h2>
			<b>¥ <?=$_item["book_price"];?></b>
		</a>
		<span class="del_fav" data="<?=$_item["id"];?>"><i class="del_fav_icon"></i></span>
	</li>
	<?php endforeach;?>
</ul>
<?php else:?>
    <div class="no-data">
        啥都没有，你瞅撒
    </div>
<?php endif;?>

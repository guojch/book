<?php
use \app\common\services\UrlService;
$tab_list = [
	'index' => [
		'title' => '财务统计',
		'url' => '/stat/index'
	],
	'product' => [
		'title' => '商品售卖',
		'url' => '/stat/product'
	],
	'member' => [
		'title' => '会员消费统计',
		'url' => '/stat/member'
	],
	'share' => [
		'title' => '分享统计',
		'url' => '/stat/share'
	]
];
?>
<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
				<?php foreach( $tab_list as  $_current => $_item ):?>
					<li <?php if( $current == $_current ):?> class="current" <?php endif;?> >
						<a href="<?=UrlService::buildWebUrl( $_item['url'] );?>"><?=$_item['title'];?></a>
					</li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>
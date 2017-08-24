<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
?>

<?php echo Yii::$app->view->renderFile("@app/modules/web/views/common/tab_brand.php",[ 'current' => 'info' ]);?>
<div class="row m-t">
	<div class="col-lg-9 col-lg-offset-2 m-t">
		<dl class="dl-horizontal">
			<dt>品牌名称</dt>
			<dd><?=$info?UtilService::encode( $info['name'] ):'';?></dd>
			<dt>品牌Logo</dt>
			<dd>
				<img class="img-circle circle-border" src="<?=UrlService::buildPicUrl( "brand",$info['logo'] );?>" style="width: 100px;height: 100px;"/>
			</dd>

			<dt>联系电话</dt>
			<dd><?=$info?UtilService::encode( $info['mobile'] ):'';?></dd>
			<dt>地址</dt>
			<dd><?=$info?UtilService::encode( $info['address'] ):'';?></dd>
			<dt>品牌介绍</dt>
			<dd><?=$info?nl2br( UtilService::encode(  $info['description'] ) ):'';?></dd>
			<dd>
				<a href="<?=UrlService::buildWebUrl("/brand/set");?>" class="btn btn-outline btn-primary btn-w-m">编辑</a>
			</dd>
		</dl>
	</div>
</div>

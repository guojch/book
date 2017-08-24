<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
use \app\common\services\UtilService;


StaticService::includeAppJsStatic( "/js/web/member/set.js",\app\assets\WebAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_member.php", ['current' => 'index']); ?>

<div class="row mg-t20 wrap_member_set">
	<div class="col-lg-12">
		<h2 class="text-center">会员设置</h2>
		<div class="form-horizontal m-t">
			<div class="hr-line-dashed"></div>
			<div class="form-group">
				<label class="col-lg-2 control-label">会员名称:</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="请输入会员名称" name="nickname" value="<?=$info?$info['nickname']:'';?>">
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<div class="form-group">
				<label class="col-lg-2 control-label">会员手机:</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="请输入会员手机" name="mobile" value="<?=$info?$info['mobile']:'';?>">
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<div class="form-group">
				<div class="col-lg-4 col-lg-offset-2">
					<input type="hidden" name="id" value="<?=$info?$info['id']:0;?>">
					<button class="btn btn-w-m btn-outline btn-primary save">保存</button>
				</div>
			</div>
		</div>
	</div>
</div>

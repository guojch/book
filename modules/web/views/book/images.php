<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
use \app\common\services\ConstantMapService;
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_book.php", ['current' => 'images']); ?>
<div class="row">
	<div class="col-lg-12">
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>图片</th>
				<th>图片地址</th>
			</tr>
			</thead>
			<tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
					<tr>
						<td>
							<img src="<?= $_item['url'];?>" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="<?= $_item['url'];?>" target="_blank">查看大图</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="2">暂无数据</td></tr>
			<?php endif;?>
			</tbody>
		</table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/book/images'
		]); ?>

	</div>
</div>

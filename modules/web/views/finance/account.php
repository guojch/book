<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
use \app\common\services\ConstantMapService;
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_finance.php", ['current' => 'account']); ?>

<div class="row">
    <div class="col-lg-12 m-t">
        <p>总收款金额：<?=$total_pay_money;?>元</p>
    </div>
	<div class="col-lg-12">
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>订单编号</th>
				<th>价格</th>
				<th>支付时间</th>
			</tr>
			</thead>
			<tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
					<tr>
						<td><?= $_item['sn'];?></td>
						<td><?= $_item['pay_price'] ;?></td>
						<td><?= $_item['pay_time'] ;?></td>
					</tr>
				<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="3">暂无数据</td></tr>
			<?php endif;?>
			</tbody>
		</table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/finance/account'
		]); ?>

	</div>
</div>

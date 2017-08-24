<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
use \app\common\services\ConstantMapService;
StaticService::includeAppJsStatic( "/js/web/finance/index.js",\app\assets\WebAsset::className() );
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_finance.php", ['current' => 'index']); ?>

<div class="row">
	<div class="col-lg-12">
		<form class="form-inline wrap_search">
			<div class="row  m-t p-w-m">
				<div class="form-group">
					<select name="status" class="form-control inline">
						<option value="<?=ConstantMapService::$status_default;?>">请选择状态</option>
						<?php foreach( $status_mapping as $_status => $_title ):?>
							<option value="<?=$_status;?>" <?php if( $search_conditions['status']  == $_status):?> selected <?php endif;?> ><?=$_title;?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
		</form>
		<hr/>
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>订单编号</th>
				<th>名称</th>
				<th>价格</th>
				<th>支付时间</th>
				<th>状态</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
					<tr>
						<td><?= $_item['sn'];?></td>
						<td>
							<?php foreach( $_item['items'] as $_order_item ):?>
								<?=$_order_item["name"];?> × <?=$_order_item["quantity"];?><br/>
							<?php endforeach;?>
						</td>
						<td><?= $_item['pay_price'] ;?></td>
						<td>
							<?php if( $_item['status'] == 1 ):?>
							<?= $_item['pay_time'] ;?>
							<?php endif;?>
						</td>
						<td><?= $_item['status_desc'];?></td>
						<td><?= $_item['created_time'];?></td>
						<td>
                            <a  href="<?=UrlService::buildWebUrl("/finance/pay_info",[ 'id' => $_item['id'] ] );?>">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
				<?php endforeach;?>
			<?php else:?>
				<tr><td colspan="7">暂无数据</td></tr>
			<?php endif;?>
			</tbody>
		</table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/finance/index',
		]); ?>

	</div>
</div>

<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
use \app\common\services\ConstantMapService;
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_book.php", ['current' => 'book']); ?>
<style type="text/css">
	.wrap_info img{
		width: 70%;
	}
</style>
<div class="row m-t wrap_info">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="m-b-md">
					<?php if( $info && $info['status'] ):?>
						<a class="btn btn-outline btn-primary pull-right" href="<?=UrlService::buildWebUrl("/book/set",[ 'id' => $info['id'] ]);?>">
							<i class="fa fa-pencil"></i>编辑
						</a>
					<?php endif;?>
					<h2>图书信息</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">图书名称：<?=UtilService::encode( $info['name'] ) ;?></p>
				<p>图书售价：<?=UtilService::encode( $info['price'] ) ;?></p>
				<p>库存总量：<?=UtilService::encode( $info['stock'] ) ;?></p>
				<p>图书标签：<?=UtilService::encode( $info['tags'] ) ;?></p>
				<p>封面图：<img src="<?=UrlService::buildPicUrl("book",$info['main_image']);?>" style="width: 50px;height: 50px;"/> </p>
				<p>图书描述：<?=$info['summary'] ;?></p>
			</div>
		</div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">销售历史</a>
                                </li>
                                <li>
                                    <a href="#tab-2" data-toggle="tab" aria-expanded="true">库存变更</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>会员名称</th>
                                        <th>购买数量</th>
                                        <th>购买价格</th>
                                        <th>订单状态</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php if( $sale_change_log_list ):?>
										<?php foreach( $sale_change_log_list as $_sale_info ):?>
                                            <tr>
                                                <td>
                                                    <?php if( $_sale_info['member_info'] ):?>
                                                    <?=UtilService::encode( $_sale_info['member_info']['nickname'] );?>
                                                    <?php endif;?>
                                                </td>
                                                <td><?=$_sale_info['quantity'];?></td>
                                                <td><?=$_sale_info['price'];?></td>
                                                <td><?=$_sale_info['created_time'];?></td>
                                            </tr>
										<?php endforeach;?>
									<?php else:?>
                                        <tr><td colspan="4">暂无销售记录</td></tr>
									<?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>变更</th>
                                        <th>备注</th>
                                        <th>时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if( $stock_change_list ):?>
                                            <?php foreach( $stock_change_list as $_stock_info ):?>
                                                <tr>
                                                    <td><?=$_stock_info['unit'];?></td>
                                                    <td><?=$_stock_info['note'];?></td>
                                                    <td><?=$_stock_info['created_time'];?></td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <tr><td colspan="3">暂无变更</td></tr>
                                        <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

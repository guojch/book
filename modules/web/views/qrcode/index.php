<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
?>

<?php echo Yii::$app->view->renderFile("@app/modules/web/views/common/tab_qrcode.php",[ 'current' => 'index' ]);?>

<div class="row">
	<div class="col-lg-12">
        <div class="row m-t">
            <div class="col-lg-12">
                <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildWebUrl("/qrcode/set");?>">
                    <i class="fa fa-plus"></i>二维码
                </a>
            </div>
        </div>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>渠道名称</th>
                <th>二维码</th>
                <th>扫码总数</th>
                <th>注册总数</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if( $list ):?>
                <?php foreach( $list as $_item ):?>
                <tr>
                    <td><?=UtilService::encode( $_item['name'] );?></td>
                    <td>
                        <img style="width: 100px;height: 100px;" src="<?=UrlService::buildWwwUrl( "/default/qrcode",[ 'qr_code_url' => $_item['qrcode'] ] );?>"/>
                    </td>
                    <td><?=UtilService::encode( $_item['total_scan_count'] );?></td>
                    <td><?=UtilService::encode( $_item['total_reg_count'] );?></td>
                    <td>
                        <a class="m-l" href="<?=UrlService::buildWebUrl("/qrcode/set",[ 'id' => $_item['id'] ]);?>">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr><td colspan="5">暂无数据</td></tr>
            <?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/pagination.php", [
		        'pages' => $pages,
				'url' => '/qrcode/index'
        ]); ?>
	</div>
</div>


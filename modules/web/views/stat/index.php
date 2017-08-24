<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/plugins/highcharts/highcharts.js",\app\assets\WebAsset::className() );

StaticService::includeAppCssStatic( "/plugins/datetimepicker/jquery.datetimepicker.min.css",\app\assets\WebAsset::className() );

StaticService::includeAppJsStatic( "/plugins/datetimepicker/jquery.datetimepicker.full.min.js",\app\assets\WebAsset::className() );


StaticService::includeAppJsStatic( "/js/web/chart.js",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/js/web/stat/index.js",\app\assets\WebAsset::className() );
?>

<?php echo Yii::$app->view->renderFile("@app/modules/web/views/common/tab_stat.php",[ 'current' => 'index' ]);?>
<div class="row m-t">
    <div class="col-lg-12" id="container" style="height: 400px;">

    </div>
    <div class="col-lg-12 m-t">
        <form class="form-inline" id="search_form_wrap">
            <div class="row p-w-m">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" placeholder="请选择开始时间" name="date_from" class="form-control"  value="<?=$search_conditions['date_from'];?>">
                    </div>
                </div>
                <div class="form-group m-r m-l">
                    <label>至</label>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" placeholder="请选择结束时间" name="date_to" class="form-control" value="<?=$search_conditions['date_to'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <a class="btn btn-w-m btn-outline btn-primary search">搜索</a>
                </div>
            </div>
            <hr/>
        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>日期</th>
                <th>营收金额</th>
            </tr>
            </thead>
            <tbody>
                <?php if( $list ):?>
                    <?php foreach( $list as $_item ):?>
                        <tr>
                            <td><?=$_item['date'];?></td>
                            <td><?=$_item['total_pay_money'];?></td>
                        </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr> <td colspan="2">暂无数据</td> </tr>
                <?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/stat/index'
		]); ?>
    </div>
</div>
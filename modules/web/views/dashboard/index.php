<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/plugins/highcharts/highcharts.js",\app\assets\WebAsset::className() );

StaticService::includeAppCssStatic( "/plugins/datetimepicker/jquery.datetimepicker.min.css",\app\assets\WebAsset::className() );

StaticService::includeAppJsStatic( "/plugins/datetimepicker/jquery.datetimepicker.full.min.js",\app\assets\WebAsset::className() );


StaticService::includeAppJsStatic( "/js/web/chart.js",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/js/web/dashboard/index.js",\app\assets\WebAsset::className() );
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">日统计</span>
                    <h5>营收概况</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=sprintf("%.2f",$data['finance']['today']);?></h1>
                    <small>近30日：<?=sprintf("%.2f",$data['finance']['month']);?></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">日统计</span>
                    <h5>订单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$data['order']['today'];?></h1>
                    <small>近30日：<?=$data['order']['month'];?></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">日统计</span>
                    <h5>会员</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$data['member']['total'];?></h1>
                    <small>今日新增：<?=$data['member']['today_new'];?></small>
                    <small>近30日新增：<?=$data['member']['month_new'];?></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">日统计</span>
                    <h5>分享</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$data['shared']['today'];?></h1>
                    <small>近30日：<?=$data['shared']['month'];?></small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" id="member_order" style="height: 400px;border: 1px solid #e6e6e6;padding-top: 20px;">

        </div>
        <div class="col-lg-12" id="finance" style="height: 400px;border: 1px solid #e6e6e6;padding-top: 20px;">

        </div>
    </div>
</div>
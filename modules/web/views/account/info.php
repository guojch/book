<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
?>
<?php echo Yii::$app->view->renderFile("@app/modules/web/views/common/tab_account.php",[ 'current' => 'index' ]);?>
<div class="row m-t">
	<div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-md">
                    <?php if( $info && $info['status']):?>
                    <a class="btn btn-outline btn-primary pull-right" href="<?=UrlService::buildWebUrl("/account/set",[ 'id' => $info['uid'] ]);?>">
                        <i class="fa fa-pencil"></i>编辑
                    </a>
                    <?php endif;?>
                    <h2>账户信息</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 text-center">
                <img class="img-circle circle-border" src="<?=UrlService::buildWwwUrl("/images/common/qrcode.jpg");?>" width="100px" height="100px"/>
            </div>
            <div class="col-lg-10">
                <p class="m-t">姓名：<?=UtilService::encode( $info['nickname'] ) ;?></p>
                <p>手机：<?=UtilService::encode( $info['mobile'] ) ;?></p>
                <p>邮箱：<?=UtilService::encode( $info['email'] ) ;?></p>
            </div>
        </div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="<?=UrlService::buildNullUrl();?>" data-toggle="tab" aria-expanded="false">访问记录</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>访问时间</th>
                                            <th>访问Url</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if( $access_list ):?>
                                        <?php foreach( $access_list as $_item ):?>
                                            <tr>
                                                <td>
                                                   <?=$_item['created_time'];?>
                                                </td>
                                            <td>
												<?=$_item['target_url'];?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <tr><td colspan="2">暂无数据</td></tr>
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

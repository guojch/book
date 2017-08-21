<?php
use \app\common\services\UrlService;
use \app\common\services\ConstantMapService;
use \yii\helpers\Html;
?>
<div class="row m-t">
	<div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-md">
                    <?php if($info && $info['status']):?>
                        <a class="btn btn-outline btn-primary pull-right" href="<?=UrlService::buildWebUrl("/member/edit",['id' => $info['id']]);?>">编辑</a>
                    <?php endif;?>
                    <h2>会员信息</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 text-center">
                <img class="img-circle" src="<?=UrlService::buildPicUrl("avatar",$info['avatar']);?>" width="100px" height="100px"/>
            </div>
            <div class="col-lg-9">
                <dl class="dl-horizontal">
                    <dt>姓名：</dt> <dd><?=Html::encode($info['nickname']);?></dd>
                    <dt>手机：</dt> <dd><?=Html::encode($info['phone']);?></dd>
                    <dt>性别：</dt> <dd><?=ConstantMapService::$sex_mapping[$info['sex']];?></dd>
                </dl>
            </div>
        </div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">会员订单</a>
                                </li>
                                <li>
                                    <a href="#tab-2" data-toggle="tab" aria-expanded="true">会员评论</a>
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
                                        <th>订单编号</th>
                                        <th>支付时间</th>
                                        <th>支付金额</th>
                                        <th>订单状态</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($order_list):?>
                                        <?php foreach($order_list as $_order_info):?>
                                            <tr>
                                                <td>
                                                    <?=date("YmdHi",strtotime($_order_info['created_time'])).$_order_info['id'];?>
                                                </td>
                                                <td>
                                                    <?php if($_order_info['status'] == 1):?>
                                                        <?=date("Y-m-d H:i",strtotime($_order_info['pay_time']));?>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?=$_order_info['pay_price'];?>
                                                </td>
                                                <td>
                                                    <?=ConstantMapService::$pay_status_mapping[$_order_info['status']];?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <tr><td colspan="4">暂无订单</td></tr>
                                    <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>评论时间</th>
                                            <th>评分</th>
                                            <th>评论内容</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($comments_list):?>
                                            <?php foreach($comments_list as $_item_comment):?>
                                                <tr>
                                                    <td>
                                                        <?=$_item_comment['created_time'];?>
                                                    </td>
                                                    <td>
                                                        <?=$_item_comment['score'];?>
                                                    </td>
                                                    <td>
                                                        <?=Html::encode($_item_comment['content']);?>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <tr><td colspan="3">暂无评论</td></tr>
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
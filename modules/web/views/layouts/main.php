<?php
use app\assets\WebAsset;
use app\common\services\UrlService;
WebAsset::register($this);
$upload_config = Yii::$app->params['upload'];
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>管理后台</title>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="profile-element text-center">
                                <img alt="image" class="img-circle" src="/images/web/logo.png" />
                                <p class="text-muted">郭小钧</p>
                            </div>
                            <div class="logo-element">
                                <img alt="image" class="img-circle" src="/images/web/logo.png" />
                            </div>
                        </li>
                        <li class="dashboard">
                            <a href="/web/dashboard/info">
                                <i class="fa fa-dashboard fa-lg"></i>
                                <span class="nav-label">仪表盘</span>
                            </a>
                        </li>
                        <li class="account">
                            <a href="/web/account/list"><i class="fa fa-user fa-lg"></i><span class="nav-label">账号管理</span></a>
                        </li>
                        <li class="brand">
                            <a href="/web/brand/info"><i class="fa fa-cog fa-lg"></i><span class="nav-label">品牌设置</span></a>
                        </li>
                        <li class="book">
                            <a href="/web/book/list"><i class="fa fa-book fa-lg"></i><span class="nav-label">图书管理</span></a>
                        </li>
                        <li class="member">
                            <a href="/web/member/list"><i class="fa fa-group fa-lg"></i><span class="nav-label">会员列表</span></a>
                        </li>
                        <li class="finance">
                            <a href="/web/order/list"><i class="fa fa-rmb fa-lg"></i><span class="nav-label">财务管理</span></a>
                        </li>
                        <li class="market">
                            <a href="/web/qrcode/list"><i class="fa fa-share-alt fa-lg"></i><span class="nav-label">营销渠道</span></a>
                        </li>
                        <li class="stat">
                            <a href="/web/stat/finance"><i class="fa fa-bar-chart fa-lg"></i><span class="nav-label">统计管理</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg" style="background-color: #ffffff;">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0);"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">
                                    欢迎使用郭小钧图书商城管理后台
                                </span>
                            </li>
                            <li class="hidden">
                                <a class="count-info" href="javascript:void(0);">
                                    <i class="fa fa-bell"></i>
                                    <span class="label label-primary">8</span>
                                </a>
                            </li>
                            <li class="dropdown user_info">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                                    <img alt="image" class="img-circle" src="/images/web/avatar.png" />
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <li>
                                        <div class="dropdown-messages-box">
                                            姓名：郭大爷<a href="/web/user/edit" class="pull-right">编辑</a>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="dropdown-messages-box">手机号码：18305906893</div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="link-block text-center">
                                            <a class="pull-left" href="/web/user/reset-pwd">
                                                <i class="fa fa-lock"></i> 修改密码
                                            </a>
                                            <a class="pull-right" href="<?= UrlService::buildWebUrl('/user/logout') ?>">
                                                <i class="fa fa-sign-out"></i> 退出
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!--根据不同的控制器id显示对应的栏目分块-->
                <?php if($controller_id == 'account'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <li class="current">
                                        <a href="/web/account/list">账户列表</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }else if($controller_id == 'book'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <?= $action_id=='list'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/book/list">图书列表</a>
                                    </li>
                                    <?= $action_id=='cat'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/book/cat">分类列表</a>
                                    </li>
                                    <?= $action_id=='images'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/book/images">图片资源</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }else if($controller_id == 'brand'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <?= $action_id=='info'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/brand/info">品牌信息</a>
                                    </li>
                                    <?= $action_id=='images'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/brand/images">品牌相册</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }else if($controller_id == 'member'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <?= $action_id=='list'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/member/list">会员列表</a>
                                    </li>
                                    <?= $action_id=='comment'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/member/comment">会员评论</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }else if($controller_id == 'order'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <?= $action_id=='list'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/finance/list">订单列表</a>
                                    </li>
                                    <?= $action_id=='finance'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/order/finance">财务流水</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }else if($controller_id == 'qrcode'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <li  class="current">
                                        <a href="/web/qrcode/list">渠道二维码</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }else if($controller_id == 'stat'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <?= $action_id=='finance'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/stat/finance">财务统计</a>
                                    </li>
                                    <?= $action_id=='product'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/stat/product">商品售卖</a>
                                    </li>
                                    <?= $action_id=='member'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/stat/member">会员消费统计</a>
                                    </li>
                                    <?= $action_id=='share'?'<li class="current">':'<li>'; ?>
                                        <a href="/web/stat/share">分享统计</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }else if($controller_id == 'user'){ ?>
                    <div class="row border-bottom">
                        <div class="col-lg-12">
                            <div class="tab_title">
                                <ul class="nav nav-pills">
                                    <?= $action_id=='edit'?'<li class="current">':'<li>'; ?>
                                        <a href="<?= UrlService::buildWebUrl('/user/edit') ?>">帐号编辑</a>
                                    </li>
                                    <?= $action_id=='reset-pwd'?'<li class="current">':'<li>'; ?>
                                        <a href="<?= UrlService::buildWebUrl('/user/reset-pwd') ?>">修改密码</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?= $content;?>
            </div>
        </div>

    <div class="hidden_layout_warp hide">
        <input type="hidden" name="upload_config" value='<?= json_encode($upload_config); ?>' />
    </div>

    <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
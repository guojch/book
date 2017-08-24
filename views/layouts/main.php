<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use \app\common\services\UrlService;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=Yii::$app->params["title"];?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-collapse collapse pull-left">
            <ul class="nav navbar-nav ">
                <li><a href="<?= UrlService::buildWwwUrl("/"); ?>">首页</a></li>
                <li><a target="_blank" href="http://blog.guojch.com/">博客</a></li>
                <li><a href="<?= UrlService::buildWebUrl("/user/login"); ?>">管理后台</a></li>
            </ul>
        </div>
    </div>
</div>
<?=$content;?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

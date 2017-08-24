<?php
use \app\common\services\UrlService;
?>

<div class="jumbotron body-content">
    <div class="jumbotron text-center">
        <img src="<?= UrlService::buildWwwUrl("/images/common/qrcode.jpg"); ?>"/>
        <h3>扫码关注！</h3>
    </div>
</div>

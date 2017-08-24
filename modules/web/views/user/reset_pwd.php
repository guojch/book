<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
use \app\common\services\ConstantMapService;
use \app\common\services\UtilService;
StaticService::includeAppJsStatic("/js/web/user/reset_pwd.js",\app\assets\WebAsset::className());
?>
<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_user.php",['current' => 'pwd']);?>
<div class="row m-t  user_reset_pwd_wrap">
    <div class="col-lg-12">
        <h2 class="text-center">修改密码</h2>
        <div class="form-horizontal m-t m-b">
            <div class="form-group">
                <label class="col-lg-2 control-label">账号:</label>
                <div class="col-lg-10">
                    <label class="control-label"><?=UtilService::encode( $info['nickname'] );?></label>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">手机:</label>
                <div class="col-lg-10">
                    <label class="control-label"><?=UtilService::encode( $info['mobile'] );?></label>
                </div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-lg-2 control-label">原密码:</label>
                <div class="col-lg-10">
                    <input type="password" id="old_password" class="form-control"  value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-lg-2 control-label">新密码:</label>
                <div class="col-lg-10">
                    <input type="password" id="new_password" class="form-control"  value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                    <button class="btn btn-w-m btn-outline btn-primary" id="save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>

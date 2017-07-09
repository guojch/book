<?php
use app\common\services\StaticService;
StaticService::includeAppJsStatic('/js/web/user/reset_pwd.js',app\assets\WebAsset::className());
?>
<div class="row m-t  user_reset_pwd_wrap">
    <div class="col-lg-12">
        <h2 class="text-center">修改密码</h2>
        <div class="form-horizontal m-t m-b">
            <div class="form-group">
                <label class="col-lg-2 control-label">账号:</label>
                <div class="col-lg-10">
                    <label class="control-label"><?= $user_info['username']; ?></label>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">手机:</label>
                <div class="col-lg-10">
                    <label class="control-label"><?= $user_info['phone']; ?></label>
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
                    <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
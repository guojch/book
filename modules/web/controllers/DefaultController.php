<?php

namespace app\modules\web\controllers;

use app\common\services\UrlService;
use app\modules\web\controllers\common\BaseController;

class DefaultController extends BaseController{

    public function actionIndex(){
        return $this->redirect( UrlService::buildWebUrl("/dashboard/index") );
    }
}

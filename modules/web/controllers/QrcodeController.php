<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Description of QrcodeController
 *
 * @author guojch
 */
class QrcodeController extends BaseController {
    //渠道二维码列表
    public function actionList(){

        return $this->render('list');
    }
    
    //渠道二维码添加与编辑
    public function actionEdit(){

        return $this->render('edit');
    }
}

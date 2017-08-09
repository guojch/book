<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\wap\controllers;

use app\modules\wap\controllers\common\BaseController;
/**
 * Description of PayController
 *
 * @author guojch
 */
class PayController extends BaseController {
    
    //购买支付页面
    public function actionBuy(){

        return $this->render('buy');
    }
}

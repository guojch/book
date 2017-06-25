<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\wap\controllers;

use yii\web\Controller;
/**
 * Description of PayController
 *
 * @author guojch
 */
class PayController extends Controller{
    
    //购买支付页面
    public function actionBuy(){
        $this->layout = false;
        return $this->render('buy');
    }
}

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
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //购买支付页面
    public function actionBuy(){

        return $this->render('buy');
    }
}

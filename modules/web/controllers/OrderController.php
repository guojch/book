<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Description of OrderController
 *
 * @author guojch
 */
class OrderController extends BaseController {
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //订单列表
    public function actionList(){

        return $this->render('list');
    }
    
    //财务流水
    public function actionFinance(){

        return $this->render('finance');
    }
    
    //订单详情
    public function actionInfo(){

        return $this->render('info');
    }
}
